<?php
require_once '../bd.php';

// Obtener productos por categoría
$bebidas = $conn->query("SELECT * FROM productos WHERE nombre LIKE '%Mojito%' OR nombre LIKE '%Piña%' OR nombre LIKE '%Margarita%' OR nombre LIKE '%Daiquiri%' OR nombre LIKE '%Sangría%' OR nombre LIKE '%Moscow%' OR nombre LIKE '%Gin%' OR nombre LIKE '%Negroni%'");
$platillos = $conn->query("SELECT * FROM productos WHERE nombre LIKE '%Arepa%' OR nombre LIKE '%Hamburguesa%' OR nombre LIKE '%Paella%' OR nombre LIKE '%Ceviche%' OR nombre LIKE '%Risotto%' OR nombre LIKE '%Pabellón%' OR nombre LIKE '%Bowl%' OR nombre LIKE '%Pasta%' OR nombre LIKE '%Sopa%'");
$cafes = $conn->query("SELECT * FROM productos WHERE nombre LIKE '%Café%' OR nombre LIKE '%Cappuccino%' OR nombre LIKE '%Moca%'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img-optimizado/cherry.png" type="image/png">
    <title>Menu - Nectar</title>
</head>
<body>
    <div id="wrapper">
        <header class="header_start">
            <div class="header_all">
                <div class="wrapper">
                    <div class="header_title_a_network">
                        <a class="h1_a" href="index.php">
                            <img class="cherry-title" src="img-optimizado/cherry_white.png" alt="title-cherry">
                        </a>    
                    </div>    
                    <div class="header_nav_bars">
                        <label for="main" class="bars-menu"> 
                            <i class="fa-solid fa-bars responsive_bar"></i>
                        </label>
                        <input type="checkbox" id="main" class="nav_input">
                        <nav class="nav_menu">    
                            <ul class="naving" role="navigation">
                                <li class="list-nav-nectar"><a href="index.php" class="nav_list">Home</a></li>
                                <li class="list-nav-nectar"><a href="menu.php" class="nav_list box-list">Menu</a></li>
                                <li class="list-nav-nectar services-main-list">
                                    <a href="#" class="nav_list">Services</a>
                                    <ul class="services-submain">
                                        <li class="submain-list"><a href="ordenar.php">Ordenar</a></li>
                                        <li class="submain-list"><a href="delivery.php">Delivery</a></li>
                                    </ul>
                                </li>
                                <li class="list-nav-nectar"><a href="about-us.php" class="nav_list">About us</a></li>
                                <li class="list-nav-nectar icon-naving"><a href="../login.php"><i class="fa-solid fa-user"></i></a></li>
                                <li class="list-nav-nectar icon-naving"><a href="payment.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                            </ul>
                        </nav>     
                    </div>
                </div>
            </div>
        </header>

        <div class="hero-carta">
            <div class="background_main_carta">
                <div class="overlow">
                    <div class="wrapper">
                        <div class="welcome">
                            <div class="text-hero">
                                <span class="span-text-hero">Carta</span>
                                <p class="p-hero">
                                    ¡¿Listo para Disfrutar en Nectar?!
                                </p>
                                <span class="description_main">Preparate para la explosion de sabor</span>
                            </div>
                            <div class="buttoms-hero">
                                <a href="ordenar.php" class="bottom-order">Ordena Ahora</a>
                                <a href="menu.php" class="bottom-view-menu">Ver Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main id="carta">
            <h2 class="title_category">Nuestras Cartas</h2>
            <div class="container_main">
                <!-- Sección de bebidas -->
                <section class="box-cards-container cocktekes">
                    <div class="wrapper">
                        <div id="popup" style="display: none;">
                            <p>¿Quieres agregar este producto al carrito?</p>
                            <button id="add-to-cart">Sí</button>
                            <button id="cancel">No</button>
                        </div>
                        <h2 class="title-drinks">Bebidas y Cockteles</h2>
                        <section class="container-cards main-drinks">
                            <?php while($bebida = $bebidas->fetch_assoc()): ?>
                            <div class="card-main drinks-cards" data-id="<?php echo $bebida['id']; ?>" 
                                 data-price="<?php echo $bebida['precio']; ?>"
                                 data-image="<?php echo $bebida['imagen']; ?>">
                                <img class="drinks-img-widths" src="<?php echo htmlspecialchars($bebida['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($bebida['nombre']); ?>">
                                <h2><?php echo htmlspecialchars($bebida['nombre']); ?></h2>
                                <p><?php echo number_format($bebida['precio'], 2); ?> €</p>
                            </div>
                            <?php endwhile; ?>
                        </section>
                    </div>
                </section>

                <!-- Sección de platillos -->
                <section class="box-cards-container startup-stars">
                    <div class="wrapper">
                        <h2 class="title-drinks">Platillos Principales</h2>
                        <section class="container-cards main-drinks">
                            <?php while($platillo = $platillos->fetch_assoc()): ?>
                            <div class="card-main startup-card" data-id="<?php echo $platillo['id']; ?>"
                                 data-price="<?php echo $platillo['precio']; ?>"
                                 data-image="<?php echo $platillo['imagen']; ?>">
                                <img class="drinks-img-widths" src="<?php echo htmlspecialchars($platillo['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($platillo['nombre']); ?>">
                                <h2><?php echo htmlspecialchars($platillo['nombre']); ?></h2>
                                <p><?php echo number_format($platillo['precio'], 2); ?> €</p>
                            </div>
                            <?php endwhile; ?>
                        </section>
                    </div>
                </section>

                <!-- Sección de cafés -->
                <section class="box-cards-container coffes">
                    <div class="wrapper">
                        <h2 class="title-drinks">Cafes Exquisitos</h2>
                        <section class="container-cards main-drinks">
                            <?php while($cafe = $cafes->fetch_assoc()): ?>
                            <div class="card-main startup-card" data-id="<?php echo $cafe['id']; ?>"
                                 data-price="<?php echo $cafe['precio']; ?>"
                                 data-image="<?php echo $cafe['imagen']; ?>">
                                <img class="drinks-img-widths" src="<?php echo htmlspecialchars($cafe['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($cafe['nombre']); ?>">
                                <h2><?php echo htmlspecialchars($cafe['nombre']); ?></h2>
                                <p><?php echo number_format($cafe['precio'], 2); ?> €</p>
                            </div>
                            <?php endwhile; ?>
                        </section>
                    </div>
                </section>
            </div>
        </main>

        <footer class="footer">
            <div class="copy_nectar about nectar footer-top">
                <div class="wrapper">
                    <div class="logo-footer">
                        <img src="img-optimizado/cherry_white.png" alt="logo nectar restaurante">
                        <section class="about-nectar">
                            <h5>Sobre Nectar</h5>
                            <p>Nectar: Tu destino culinario para una experiencia gastronómica inolvidable. Descubre la fusión perfecta de sabores frescos y creatividad en nuestro restaurante de comida. Deléitate con platos exquisitos preparados con pasión y atención al detalle. ¡Bienvenido a Nectar, donde cada bocado es una celebración de la buena comida!</p>
                            <div class="links-footer">
                                <a class="chef-reds instragram-chef" href="#"><i class="fa-brands fa-instagram"></i></a>
                                <a class="chef-reds twiter-chef" href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a class="chef-reds twiter-chef" href="#"><i class="fa-brands fa-facebook"></i></a>
                            </div>
                        </section>
                    </div>
                    <section class="footer-links-red">
                        <div class="title-links-about">
                            <h5 class="footer-title about-nectar">Nuestras redes sociales</h5>
                        </div>
                        <ul class="links-about-us-nectar">
                            <li class="items-links-reds"><i class="fa-brands fa-facebook"></i><a href="#">Facebook</a></li>
                            <li class="items-links-reds"><i class="fa-solid fa-x"></i><a href="#">Twitter</a></li>
                            <li class="items-links-reds"><i class="fa-brands fa-instagram"></i><a href="#">Instagram</a></li>
                            <li class="items-links-reds"><i class="fa-brands fa-whatsapp"></i><a href="#">Whatsapp</a></li>
                        </ul>
                    </section>
                    <section class="info-nectar">
                        <div class="title-footer-nectar-info">
                            <h5 class="footer-title info-title">Contáctanos</h5>
                        </div>
                        <ul class="list-info-customer">
                            <li class="info-nectar li-items">
                                <h5 class="phone-nectar-items">Teléfono:</h5>
                                <a href="tel:+34917208608">+34 91 720 86 08</a>
                            </li>
                            <li class="info-nectar li-items">
                                <h5 class="email-nectar-items">Correo electrónico:</h5>
                                <a href="mailto:contact-nectar@gmail.com">contact-nectar@gmail.com</a>
                            </li>
                            <li class="info-nectar li-items">
                                <h5 class="ubication-nectar-items">Localizados</h5>
                                <a href="#">C / Enteça 290</a>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="wrapper">
                    <p>Todos los derechos reservados, Hecho por Kris</p>
                    <p>Nectar&#169; Restaurant Inc</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="js/getProduct.js"></script>
</body>
</html>
<?php
// Cerrar las conexiones de base de datos
$conn->close();
?> 