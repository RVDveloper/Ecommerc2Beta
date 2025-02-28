<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago de Prueba Exitoso - Nectar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <style>
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .test-badge {
            display: inline-block;
            background-color: #6772e5;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success-actions {
            margin-top: 20px;
        }
        .btn-continue {
            display: inline-block;
            background-color: #32CD32;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .btn-continue:hover {
            background-color: #228B22;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="test-badge">Modo de Prueba</div>
        <h1>¡Pago de Prueba Exitoso!</h1>
        <p>Tu pedido ha sido procesado correctamente en el entorno de pruebas.</p>
        <p style="color: #666; margin-top: 10px;">
            Recuerda: Este es un pago simulado y no se ha realizado ningún cargo real.
        </p>
        <div class="success-actions">
            <a href="menu.php" class="btn-continue">Volver al Menú</a>
        </div>
    </div>
    <script>
        // Limpiar el carrito después de un pago exitoso
        localStorage.removeItem('cart');
    </script>
</body>
</html>