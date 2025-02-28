<?php
session_start(); // Iniciar sesión
include("bd.php"); // Incluir la conexión a la base de datos

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar que los campos no estén vacíos
    if (empty($name) || empty($email) || empty($password)) {
        $error_message = "Todos los campos son obligatorios.";
    } else {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario en la base de datos
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            if ($stmt->execute()) {
                $success_message = "";
            } else {
                $error_message = "❌ Error al registrar el usuario: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "❌ Error al preparar la consulta: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="templates/css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="templates/css/style.css">
    <link rel="stylesheet" href="templates/css/reserva.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="templates/img-optimizado/cherry.png" type="image/png">
    <title>Registro</title>
</head>
<body>
    <header class="header_start">
        <div class="header_all">
            <div class="wrapper">
                <div class="header_title_a_network">
                    <a class="h1_a" href="/templates/index.html">
                        <img class="cherry-title" src="templates/img-optimizado/cherry_white.png" alt="title-cherry">
                    </a>    
                </div>    
                <div class="header_nav_bars">
                    <label for="main" class="bars-menu"> 
                        <i class="fa-solid fa-bars responsive_bar"></i>
                    </label>
                    <input type="checkbox" id="main" class="nav_input">    <!-- Menu bar on mobile view -->
                    <nav class="nav_menu">    
                        <ul>
                            <li class="list-nav-nectar"><a href="templates/index.html" class="nav_list">Home</a></li>
                            <li class="list-nav-nectar"><a href="templates/menu.html" class="nav_list box-list">Menu</a></li>
                            <li class="list-nav-nectar services-main-list">
                                <a href="#" class="nav_list">Services</a>
                                <ul class="services-submain">
                                    <li class="submain-list"><a href="templates/ordernar.html">Ordenar</a></li>
                                    <li class="submain-list"><a href="templates/delivery.html">Delivery</a></li>
                                </ul>
                            </li>
                            <li class="list-nav-nectar"><a href="#" class="nav_list">About us</a></li>
                        </ul>
                    </nav>     
                </div>
            </div>
        </div>
    </header>
    <main id="main">
        <div class="form-reserva">
            <div class="wrapper">
                <h2 class="title-reserva">Regístrate</h2>
                <?php
                // Mostrar mensajes de éxito o error
                if (isset($success_message)) {
                    echo "<p class='success-message'>$success_message</p>";
                }
                if (isset($error_message)) {
                    echo "<p class='error-message'>$error_message</p>";
                }
                ?>
                <form class="formulary" action="" method="post">
                    <ul class="form-ul">
                        <li class="form_ul_li">
                            <input type="text" name="name" id="name" required/>
                            <label for="name">Nombre</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="email" name="email" id="email" required/>
                            <label for="email">Email</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="password" name="password" id="password" required/>
                            <label for="password">Contraseña</label>
                        </li>
                    </ul>
                    <input class="float" type="submit" value="Registrarse">
                </form>
                <p class="register-link">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </main>
</body>
</html>