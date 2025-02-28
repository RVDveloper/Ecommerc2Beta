<?php
$host = "localhost"; // Servidor (en XAMPP suele ser localhost)
$usuario = "root"; // Usuario de MySQL
$password = ""; // Contraseña (vacía por defecto en XAMPP)
$bd = "nectar"; // Nombre de la base de datos

// Conectar al servidor MySQL
$conn = new mysqli($host, $usuario, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $bd";
if ($conn->query($sql) === TRUE) {
    // echo "✅ Base de datos asegurada<br>";
} else {
    die("❌ Error al crear la base de datos: " . $conn->error);
}

// Seleccionar la base de datos
$conn->select_db($bd);

// Crear la tabla `users` si no existe
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    // echo "✅ Tabla 'users' asegurada.<br>";
} else {
    die("❌ Error al crear la tabla 'users': " . $conn->error);
}

// Crear la tabla `productos` si no existe
$sql = "CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    // echo "✅ Tabla 'productos' asegurada.<br>";
} else {
    die("❌ Error al crear la tabla 'productos': " . $conn->error);
}

// Crear la tabla `pedidos` si no existe
$sql = "CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado VARCHAR(50) DEFAULT 'pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    // echo "✅ Tabla 'pedidos' asegurada.<br>";
} else {
    die("❌ Error al crear la tabla 'pedidos': " . $conn->error);
}

// Crear la tabla `pedidos_detalle` si no existe
$sql = "CREATE TABLE IF NOT EXISTS pedidos_detalle (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
)";

if ($conn->query($sql) === TRUE) {
    // echo "✅ Tabla 'pedidos_detalle' asegurada.<br>";
} else {
    die("❌ Error al crear la tabla 'pedidos_detalle': " . $conn->error);
}

// Crear la tabla `pagos` si no existe (actualizada para Stripe)
$sql = "CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    stripe_session_id VARCHAR(255) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
)";

if ($conn->query($sql) === TRUE) {
    // echo "✅ Tabla 'pagos' asegurada.<br>";
} else {
    die("❌ Error al crear la tabla 'pagos': " . $conn->error);
}

// echo "✅ Conexión y estructura de la base de datos aseguradas.";

?>