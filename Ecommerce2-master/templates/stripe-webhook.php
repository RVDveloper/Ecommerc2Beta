<?php
// Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Stripe-Signature, *');

// Si es una solicitud OPTIONS, responder inmediatamente
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../vendor/autoload.php';
require_once '../bd.php';

// Configurar la clave secreta de prueba de Stripe
\Stripe\Stripe::setApiKey('sk_test_51QsQLfLXZjkx9hbv0QGx6O4TudMmO6niCACP3KYIO2iP5zhchorasVZ140lVyE2Mc5VJwtdQlSEJd9fDXxLIcmh800RLUIASU3');

// Configurar el signing secret del webhook
$endpoint_secret = 'whsec_IHkUBJH5pv8D8W2yxdOteCGkxnIohOpo';

// Función para registrar errores y debug en un archivo de log
function logMessage($type, $message, $data = []) {
    try {
        $logDir = __DIR__;
        $logFile = $logDir . '/stripe_debug.log';
        
        // Verificar si podemos escribir en el directorio
        if (!is_writable($logDir)) {
            error_log("El directorio no tiene permisos de escritura: " . $logDir);
            return;
        }
        
        // Si el archivo no existe, intentar crearlo
        if (!file_exists($logFile)) {
            touch($logFile);
            chmod($logFile, 0666);
        }
        
        // Verificar si podemos escribir en el archivo
        if (!is_writable($logFile)) {
            error_log("El archivo de log no tiene permisos de escritura: " . $logFile);
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] [{$type}] {$message}\n";
        if (!empty($data)) {
            $logMessage .= json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
        }
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    } catch (Exception $e) {
        error_log("Error al escribir en el log: " . $e->getMessage());
    }
}

// Log inicial para verificar que el script se está ejecutando
logMessage('INFO', 'Webhook script iniciado', [
    'time' => time(),
    'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
    'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN',
    'http_host' => $_SERVER['HTTP_HOST'] ?? 'UNKNOWN',
    'request_uri' => $_SERVER['REQUEST_URI'] ?? 'UNKNOWN',
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'UNKNOWN',
    'https' => isset($_SERVER['HTTPS']) ? 'yes' : 'no',
    'all_headers' => getallheaders()
]);

// Verificar que estamos en la URL correcta
$expected_host = 'severely-equal-yeti.ngrok-free.app';
if ($_SERVER['HTTP_HOST'] !== $expected_host) {
    logMessage('WARNING', 'Host incorrecto', [
        'expected' => $expected_host,
        'received' => $_SERVER['HTTP_HOST']
    ]);
}

try {
    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
    
    logMessage('DEBUG', 'Verificando firma del webhook', [
        'payload_length' => strlen($payload),
        'has_signature' => !empty($sig_header),
        'signature' => $sig_header,
        'headers' => getallheaders(),
        'raw_payload' => $payload
    ]);

    if (empty($payload)) {
        logMessage('ERROR', 'Payload vacío');
        throw new Exception('No se recibió payload');
    }

    try {
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
        );
        logMessage('INFO', 'Firma verificada correctamente', [
            'event_id' => $event->id,
            'event_type' => $event->type
        ]);
    } catch(\UnexpectedValueException $e) {
        logMessage('ERROR', 'Payload inválido', ['error' => $e->getMessage()]);
        http_response_code(400);
        echo json_encode(['error' => 'Payload inválido']);
        exit();
    } catch(\Stripe\Exception\SignatureVerificationException $e) {
        logMessage('ERROR', 'Firma inválida', ['error' => $e->getMessage()]);
        http_response_code(400);
        echo json_encode(['error' => 'Firma inválida']);
        exit();
    }

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;
        
        logMessage('INFO', 'Procesando checkout completado', [
            'session_id' => $session->id,
            'amount' => $session->amount_total
        ]);

        // Verificar conexión a la base de datos
        if (!$conn || $conn->connect_error) {
            throw new Exception("Error de conexión a la base de datos: " . ($conn ? $conn->connect_error : "No hay conexión"));
        }

        // Actualizar el estado del pedido
        $stmt = $conn->prepare("UPDATE pedidos SET estado = 'completado' WHERE session_id = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $session->id);
        $stmt->execute();
        
        logMessage('INFO', 'Actualización de estado del pedido', [
            'session_id' => $session->id,
            'affected_rows' => $stmt->affected_rows
        ]);

        // Obtener el ID del pedido
        $stmt = $conn->prepare("SELECT id, total FROM pedidos WHERE session_id = ?");
        $stmt->bind_param("s", $session->id);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_assoc();

        if (!$pedido) {
            throw new Exception("No se encontró el pedido con session_id: " . $session->id);
        }

        logMessage('INFO', 'Pedido encontrado', [
            'pedido_id' => $pedido['id'],
            'total' => $pedido['total']
        ]);

        // Actualizar el stock
        $stmt = $conn->prepare("
            SELECT pd.producto_id, pd.cantidad, p.stock 
            FROM pedidos_detalle pd 
            JOIN productos p ON pd.producto_id = p.id 
            WHERE pd.pedido_id = ?
        ");
        $stmt->bind_param("i", $pedido['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $updateStmt = $conn->prepare("
                UPDATE productos 
                SET stock = stock - ? 
                WHERE id = ? AND stock >= ?
            ");
            $updateStmt->bind_param("iii", 
                $row['cantidad'], 
                $row['producto_id'],
                $row['cantidad']
            );
            $updateStmt->execute();
            
            logMessage('INFO', 'Stock actualizado', [
                'producto_id' => $row['producto_id'],
                'cantidad' => $row['cantidad'],
                'affected_rows' => $updateStmt->affected_rows
            ]);
        }

        // Registrar el pago
        $stmt = $conn->prepare("
            INSERT INTO pagos (payment_id, amount, status) 
            VALUES (?, ?, ?)
        ");
        
        $status = 'completed';
        $amount = $pedido['total'];
        
        $stmt->bind_param("sds", $session->id, $amount, $status);
        $result = $stmt->execute();
        
        logMessage('INFO', 'Intento de registro de pago', [
            'success' => $result,
            'payment_id' => $session->id,
            'amount' => $amount,
            'affected_rows' => $stmt->affected_rows
        ]);

        if (!$result) {
            throw new Exception("Error al registrar el pago: " . $conn->error);
        }

        http_response_code(200);
        echo json_encode(['status' => 'success']);
    } else {
        logMessage('INFO', 'Evento ignorado', ['type' => $event->type]);
        http_response_code(200);
        echo json_encode(['status' => 'ignored']);
    }

} catch (Exception $e) {
    logMessage('ERROR', 'Error general en el webhook', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?> 