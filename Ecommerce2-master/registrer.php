<?php
session_start(); // Iniciar sesión
include("bd.php"); // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar que los campos no estén vacíos
    if (empty($name) || empty($email) || empty($password)) {
        die("Todos los campos son obligatorios.");
    }

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        if ($stmt->execute()) {
            echo "✅ Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            echo "❌ Error al registrar el usuario: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ Error al preparar la consulta: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form action="" method="post">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required placeholder="Ingresa tu nombre"/>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required placeholder="Ingresa tu email"/>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required placeholder="Ingresa tu contraseña"/>

        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
</body>
</html>