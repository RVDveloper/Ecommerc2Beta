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
    <link rel="stylesheet" href="css/reserva.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="img-optimizado/cherry.png" type="image/png">
    <title>Reservas</title>
</head>
<body>
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
                            <li class="list-nav-nectar"><a href="about-us.html" class="nav_list">About us</a></li>
                            <li class="list-nav-nectar icon-naving"><a href="../login.php"><i class="fa-solid fa-user"></i></a></li>
                            <li class="list-nav-nectar icon-naving"><a href="payment.php"><i class="fa-solid fa-cart-shopping"></i></a></i></li>
                        </ul>
                    </nav>     
                </div>
            </div>
        </div>
    </header>
    <main id="main">
        <div class="form-reserva">
            <div class="wrapper">
                <h2 class="title-reserva">Reserve su Mesa Ahora</h2>
                <form class="formulary" action="registrer.php">
                    <ul class="form-ul">
                        <li class="form_ul_li">
                            <input type="text" name="nombre" id="nombre" required/>
                            <label for="nombre">Nombre</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="text" name="apellido" id="apellido" required/>
                            <label for="apellido">Apellido</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="text" name="telefono" id="telefono" required/>
                            <label for="telefono">Telefono</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="text" name="email" id="email" required>
                            <label for="email">Ingresa tu Email</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="date" name="fecha" id="fecha"  required/>
                            <label for="fecha">Ingresa la fecha a Reservar</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="time" name="hora" id="hora" value="Fecha" required/>
                            <label for="hora">Ingresa la hora a Reservar</label>
                        </li>
                        <li class="form_ul_li">
                            <input type="number" name="asientos" id="asientos" required/>
                            <label for="asientos">Ingresa las personas a Reservar</label>
                        </li>
                    </ul>
                    <input class="float" type="submit" value="Reservar">
                </form>
            </div>
        </div>
    </main>
</body>
</html>