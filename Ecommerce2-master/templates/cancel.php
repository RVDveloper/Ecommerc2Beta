<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago de Prueba Cancelado - Nectar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <style>
        .cancel-container {
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
        .cancel-actions {
            margin-top: 20px;
        }
        .btn-return, .btn-continue {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin: 0 10px;
        }
        .btn-return {
            background-color: #dc3545;
            color: white;
        }
        .btn-continue {
            background-color: #32CD32;
            color: white;
        }
        .btn-return:hover {
            background-color: #c82333;
        }
        .btn-continue:hover {
            background-color: #228B22;
        }
    </style>
</head>
<body>
    <div class="cancel-container">
        <div class="test-badge">Modo de Prueba</div>
        <h1>Pago de Prueba Cancelado</h1>
        <p>Tu pago de prueba ha sido cancelado. No se ha realizado ningún cargo.</p>
        <p style="color: #666; margin-top: 10px;">
            Recuerda: Esto es solo una simulación en el entorno de pruebas.
        </p>
        <div class="cancel-actions">
            <a href="payment.php" class="btn-return">Volver al Carrito</a>
            <a href="menu.php" class="btn-continue">Continuar Comprando</a>
        </div>
    </div>
</body>
</html>