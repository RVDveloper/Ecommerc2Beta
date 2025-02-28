<?php
require_once 'bd.php';

// Array con los productos a insertar
$productos = [
    // Bebidas y Cócteles
    [
        'nombre' => 'Mojito Clásico',
        'descripcion' => 'Cóctel refrescante con ron, hierba buena y lima',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cocktail.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Piña Colada',
        'descripcion' => 'Delicioso cóctel tropical con ron, coco y piña',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cocktail2.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Margarita',
        'descripcion' => 'Cóctel mexicano con tequila, triple sec y lima',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cocktail3.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Daiquiri',
        'descripcion' => 'Cóctel cubano con ron blanco y limón',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cocktail4.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Caipirinha',
        'descripcion' => 'Cóctel brasileño con cachaça y lima',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cocktail5.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Sangría Especial',
        'descripcion' => 'Bebida española con vino tinto y frutas',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/drink6.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Moscow Mule',
        'descripcion' => 'Cóctel con vodka, cerveza de jengibre y lima',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/drink7.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Gin Tonic Premium',
        'descripcion' => 'Gin tonic con botánicos seleccionados',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/drink8.jpg',
        'stock' => 50
    ],
    [
        'nombre' => 'Negroni',
        'descripcion' => 'Cóctel italiano con gin, vermut rojo y Campari',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/drink9.jpg',
        'stock' => 50
    ],

    // Platillos Principales
    [
        'nombre' => 'Arepas Venezolanas',
        'descripcion' => 'Arepas rellenas con diferentes ingredientes',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/Arepas.webp',
        'stock' => 30
    ],
    [
        'nombre' => 'Hamburguesa Gourmet',
        'descripcion' => 'Hamburguesa artesanal con ingredientes premium',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/hamburguesa.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Paella Valenciana',
        'descripcion' => 'Auténtica paella española con mariscos',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/paella.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Ceviche Peruano',
        'descripcion' => 'Pescado fresco marinado en limón',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/ceviche1.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Risotto de Setas',
        'descripcion' => 'Risotto cremoso con variedad de setas',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/dish-3.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Pabellón Criollo',
        'descripcion' => 'Plato tradicional venezolano',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/pabellon-original.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Bowl Saludable',
        'descripcion' => 'Bowl con quinoa, aguacate y proteína',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/casey-lee-awj7sRviVXo-unsplash.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Pasta al Pesto',
        'descripcion' => 'Pasta fresca con salsa pesto casera',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/comida1.jpg',
        'stock' => 30
    ],
    [
        'nombre' => 'Sopa del Día',
        'descripcion' => 'Sopa casera preparada diariamente',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/sopa-slider.jpg',
        'stock' => 30
    ],

    // Cafés
    [
        'nombre' => 'Café Espresso',
        'descripcion' => 'Café espresso intenso y aromático',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cafe7.jpg',
        'stock' => 100
    ],
    [
        'nombre' => 'Cappuccino',
        'descripcion' => 'Café con espuma de leche y cacao',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cafe 6.jpg',
        'stock' => 100
    ],
    [
        'nombre' => 'Café Latte',
        'descripcion' => 'Café con leche cremosa',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cafe3.jpg',
        'stock' => 100
    ],
    [
        'nombre' => 'Café Americano',
        'descripcion' => 'Café negro suave y aromático',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cafe1.jpg',
        'stock' => 100
    ],
    [
        'nombre' => 'Moca',
        'descripcion' => 'Café con chocolate y leche',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cafe2.jpg',
        'stock' => 100
    ],
    [
        'nombre' => 'Café Frappé',
        'descripcion' => 'Café helado con crema batida',
        'precio' => 10.00,
        'imagen' => 'img-optimizado/cafe5.jpg',
        'stock' => 100
    ]
];

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen, stock) VALUES (?, ?, ?, ?, ?)");

// Insertar cada producto
foreach ($productos as $producto) {
    $stmt->bind_param("ssdsi", 
        $producto['nombre'],
        $producto['descripcion'],
        $producto['precio'],
        $producto['imagen'],
        $producto['stock']
    );
    
    if ($stmt->execute()) {
        echo "Producto '{$producto['nombre']}' insertado correctamente<br>";
    } else {
        echo "Error al insertar '{$producto['nombre']}': " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();
?> 