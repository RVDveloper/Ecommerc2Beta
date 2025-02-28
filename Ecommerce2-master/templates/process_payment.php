<?php
header('Content-Type: application/json');
require_once '../vendor/autoload.php';
require_once '../bd.php';

// Configurar la clave secreta de prueba de Stripe
\Stripe\Stripe::setApiKey('sk_test_51QsQLfLXZjkx9hbv0QGx6O4TudMmO6niCACP3KYIO2iP5zhchorasVZ140lVyE2Mc5VJwtdQlSEJd9fDXxLIcmh800RLUIASU3');

// Leer y validar los datos de entrada
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['cart']) || !is_array($data['cart'])) {
    http_response_code(400);
    echo json_encode([
        'error' => [
            'message' => 'Datos del carrito no válidos',
            'debug' => ['input' => $input, 'data' => $data]
        ]
    ]);
    exit;
}

try {
    // Verificar el stock antes de crear la sesión de pago
    $stockAvailable = true;
    $errors = [];
    
    foreach ($data['cart'] as $item) {
        if (!isset($item['id']) || !isset($item['quantity'])) {
            throw new Exception('Formato de producto inválido');
        }
        
        $stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $item['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if (!$product || $product['stock'] < $item['quantity']) {
            $stockAvailable = false;
            break;
        }
        
        $stmt->close();
    }
    
    if (!$stockAvailable) {
        throw new Exception('Stock insuficiente');
    }

    // Crear los line_items para Stripe
    $line_items = [];
    foreach ($data['cart'] as $item) {
        // Validar que todos los campos necesarios estén presentes
        if (!isset($item['name']) || !isset($item['price']) || !isset($item['quantity'])) {
            throw new Exception('Datos de producto incompletos');
        }

        // Construir la URL de la imagen para localhost
        $imageUrl = isset($item['image']) ? 'http://localhost/Ecommerce2-master/' . $item['image'] : null;

        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $item['name'],
                    'images' => $imageUrl ? [$imageUrl] : [],
                ],
                'unit_amount' => intval($item['price'] * 100), // Convertir a centavos
            ],
            'quantity' => $item['quantity'],
        ];
    }

    // Crear la sesión de Stripe para el entorno de pruebas
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/Ecommerce2-master/templates/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/Ecommerce2-master/templates/cancel.php',
        'metadata' => [
            'is_test' => 'true'
        ]
    ]);

    // Guardar la información de la sesión en la base de datos
    $stmt = $conn->prepare("INSERT INTO pedidos (session_id, total, estado) VALUES (?, ?, 'pendiente')");
    $total = array_reduce($data['cart'], function($sum, $item) {
        return $sum + ($item['price'] * $item['quantity']);
    }, 0);
    $stmt->bind_param("sd", $session->id, $total);
    $stmt->execute();
    $pedido_id = $conn->insert_id;

    // Guardar los detalles del pedido
    $stmt = $conn->prepare("INSERT INTO pedidos_detalle (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
    foreach ($data['cart'] as $item) {
        $stmt->bind_param("iiid", $pedido_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // No actualizamos el stock aquí, lo haremos cuando el pago sea confirmado
    
    // Devolver el ID de la sesión
    echo json_encode([
        'id' => $session->id,
        'is_test' => true
    ]);

} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(400);
    echo json_encode(['error' => [
        'message' => $e->getMessage(),
        'type' => 'stripe_error'
    ]]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => [
        'message' => $e->getMessage(),
        'type' => 'server_error'
    ]]);
}

$conn->close();
?>