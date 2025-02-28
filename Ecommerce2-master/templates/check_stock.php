<?php
header('Content-Type: application/json');
require_once '../bd.php';

// Leer y decodificar el JSON de entrada
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['cart']) || !is_array($data['cart'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Datos del carrito no válidos',
        'debug' => ['input' => $input, 'data' => $data]
    ]);
    exit;
}

try {
    $stockAvailable = true;
    $errors = [];
    $cart = $data['cart'];

    foreach ($cart as $item) {
        if (!isset($item['id']) || !isset($item['quantity'])) {
            $errors[] = "Formato de producto inválido";
            continue;
        }

        $stmt = $conn->prepare("SELECT nombre, stock FROM productos WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("i", $item['id']);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            $errors[] = "El producto con ID {$item['id']} no existe.";
            $stockAvailable = false;
        } elseif ($product['stock'] < $item['quantity']) {
            $errors[] = "Stock insuficiente para {$product['nombre']}. Disponible: {$product['stock']}, Solicitado: {$item['quantity']}.";
            $stockAvailable = false;
        }
        
        $stmt->close();
    }

    echo json_encode([
        'success' => $stockAvailable,
        'errors' => $errors
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

$conn->close();
?>