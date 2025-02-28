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

    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="css/style.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img-optimizado/cherry.png" type="image/png">
    
    <title>Pagos</title>
    <!-- Cargar Stripe.js primero -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Luego cargar nuestro script -->
    <script src="js/payment.js" defer></script>
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
                        <input type="checkbox" id="main" class="nav_input">    <!-- Menu bar on mobile view -->
                        <nav class="nav_menu">    
                            <ul class="naving" role="navigation">
                                <li class="list-nav-nectar"><a href="index.php" class="nav_list">Home</a></li>
                                <li class="list-nav-nectar"><a href="menu.php" class="nav_list box-list">Menu</a></li>
                                <li class="list-nav-nectar services-main-list">
                                    <a href="#" class="nav_list">Services</a>
                                    <ul class="services-submain">
                                        <li class="submain-list"><a href="ordernar.php">Ordenar</a></li>
                                        <li class="submain-list"><a href="delivery.php">Delivery</a></li>
                                    </ul>
                                </li>
                                <li class="list-nav-nectar"><a href="about-us.php" class="nav_list">About us</a></li>
                                <li class="list-nav-nectar icon-naving"><a href="../login.php"><i class="fa-solid fa-user"></i></a></li>
                                <li class="list-nav-nectar icon-naving"><a href="payment.php"><i class="fa-solid fa-cart-shopping"></i></a></i></li>
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
                                <a href="ordenar.html" class="bottom-order">Ordena Ahora</a>
                                <a href="menu.html" class="bottom-view-menu">Wiev Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <main id="payment">
            <section id="list-shopping">
                <div class="wrapper">
                    <h2>Tu Carrito de Compras</h2>
                    <div id="cart-error" class="error-message" style="display: none;"></div>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cart-table-body">
                            <!-- El contenido se generará dinámicamente -->
                        </tbody>
                    </table>
                    <div id="cart-summary"></div>
                    <div class="cart-actions">
                        <button id="clear-cart" class="btn-clear">Vaciar Carrito</button>
                        <button id="checkout" class="btn-checkout">Proceder al Pago</button>
                    </div>
                    <div id="payment-error" class="error-message" style="display: none;"></div>
                </div>
            </section>
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
                            <li class="items-links-reds"><i class="fa-brands fa-whatsapp"></i><a href="#">Whatsapp </a></li>
                        </ul>
                    </section>
                    <section class="info-nectar">
                        <div class="title-footer-nectar-info">
                            <h5 class="footer-title info-title">Contactanos</h5>
                        </div>
                        <ul class="list-info-customer">
                            <li class="info-nectar li-items">
                                <h5 class="phone-nectar-items">Teléfono:</h5>
                                <a href="#">+34 91 720 86 08</a>
                            </li>
                            <li class="info-nectar li-items">
                                <h5 class="email-nectar-items">Correo electrónico:</h5>
                                <a href="#">contact-nectar@gmail.com</a>
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
                    <p></p>Todos los derechos  reservados, Hecho por Kris</p>
                    <p>Nectar&#169; Restaurant Inc</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>