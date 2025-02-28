<?php
session_start(); // Iniciar sesión
include("bd.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Preparar consulta para evitar inyecciones SQL
    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $rows = $resultado->fetch_assoc();

            if (password_verify($password, $rows["password"])) {
                $_SESSION["email"] = $email;
                header("Location: templates/index.php"); // Redirigir al index.html
                exit;
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Usuario no encontrado";
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
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
    <title>Login</title>
</head>
<body>
    <header class="header_start">
        <div class="header_all">
            <div class="wrapper">
                <div class="header_title_a_network">
                    <a class="h1_a" href="/templates/index.php">
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
                            <li class="list-nav-nectar"><a href="/templates/index.php" class="nav_list">Home</a></li>
                            <li class="list-nav-nectar"><a href="/templates/menu.php" class="nav_list box-list">Menu</a></li>
                            <li class="list-nav-nectar services-main-list">
                                <a href="#" class="nav_list">Services</a>
                                <ul class="services-submain">
                                    <li class="submain-list"><a href="/templates/ordernar.php">Ordenar</a></li>
                                    <li class="submain-list"><a href="/templates/delivery.php">Delivery</a></li>
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
                <h2 class="title-reserva">Iniciar Sesión</h2>
                <form class="formulary" action="" method="POST">
                    <ul class="form-ul">
                        <li class="form_ul_li">
                            <input type="email" name="email" id="email" required placeholder=""/>
                            <label for="email">Email</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="password" name="password" id="password" required placeholder=""/>
                            <label for="password">Contraseña</label>
                        </li>
                    </ul>
                    <input class="float" type="submit" value="Iniciar Sesión">
                </form>
                <p class="register-link">¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
            </div>
        </div>
    </main>
</body>
</html>