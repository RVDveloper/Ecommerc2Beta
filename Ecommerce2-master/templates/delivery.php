<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/reset.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reserva.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="img-optimizado/cherry.png" type="image/png">

    <title>Reservar Delivery</title>
</head>
<body>
    <header class="header_start">
        <div class="header_all">
            <div class="wrapper">
                <div class="header_title_a_network">
                    <a class="h1_a" href="index.html">
                        <img class="cherry-title" src="img-optimizado/cherry_white.png" alt="title-cherry">
                    </a>    
                </div>    
                <div class="header_nav_bars">
                    <label for="main" class="bars-menu"> 
                        <i class="fa-solid fa-bars responsive_bar"></i>
                    </label>
                    <input type="checkbox" id="main" class="nav_input">    <!-- Menu bar on mobile view -->
                    <nav class="nav_menu">    
                        <ul>
                            <li class="list-nav-nectar"><a href="index.html" class="nav_list">Home</a></li>
                            <li class="list-nav-nectar"><a href="menu.html" class="nav_list box-list">Menu</a></li>
                            <li class="list-nav-nectar services-main-list">
                                <a href="#" class="nav_list">Services</a>
                                <ul class="services-submain">
                                    <li class="submain-list"><a href="ordernar.html">Ordenar</a></li>
                                    <li class="submain-list"><a href="delivery.html">Delivery</a></li>
                                </ul>
                            </li>
                            <li class="list-nav-nectar"><a href="about-us.html" class="nav_list">About us</a></li>
                            <li class="list-nav-nectar icon-naving"><a href="../login.php"><i class="fa-solid fa-user"></i></a></li>
                                <li class="list-nav-nectar icon-naving"><a href="payment.html"><i class="fa-solid fa-cart-shopping"></i></a></i></li>

                        </ul>
                    </nav>     
                </div>
            </div>
        </div>
    </header>
    <main id="main" class="reserve-container delivery">
        <section class="reserve delivery">
            <div class="maps-nectar">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d95689.02672900232!2d2.172518399999991!3d41.45479680000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4987f7c171639%3A0xcfa9069e4be322d5!2sEscola%20Espai!5e0!3m2!1ses-419!2ses!4v1708768257632!5m2!1ses-419!2ses" width="1000" height="420" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="wrapper">
                <div class="book-a-table">
                    <div class="form-appointer">
                        <h2 class="title-reserva-summary">Reserve su Mesa Ahora</h2>
                        <form class="formulary" action="registrer.php">
                            <ul class="form-ul">
                                <li class="div-name">
                                    <ul class="ul-items-form">
                                        <li class="form_ul_li">
                                            <input type="text" name="nombre" id="nombre" required/>
                                            <label for="nombre">Nombre</label>
                                        </li>
                                        <li class="form_ul_li">
                                            <input type="text" name="apellido" id="apellido" required/>
                                            <label for="apellido">Apellido</label>
                                        </li>
                                    </ul>
                                </li>
                                <li class="div-email-phone">
                                    <ul class="ul-items-form">
                                        <li class="form_ul_li">
                                            <input type="text" name="direccion" id="direccion"  required/>
                                            <label for="direccion">Direccion</label>
                                        </li>
                                        
                                        </li>
                                        <li class="form_ul_li">
                                            <input type="text" name="telefono" id="telefono" required/>
                                            <label for="telefono">Telefono</label>
                                        </li>
                                    </ul>
                                </li>
                                <li class="div-messege">
                                    <ul class="ul-items-form">
                                        <li class="form_ul_li">
                                            <input type="text" name="messege" id="messege" required>
                                            <label for="messege">Mas</label>
                                        </li>
                                        <li class="submit">
                                            <input class="f" type="submit" value="Reservar">
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>