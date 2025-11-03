<?php
session_start();

// Productos disponibles
$productos = array(
    1 => array('id' => 1, 'nombre' => 'Laptop HP', 'precio' => 899.99),
    2 => array('id' => 2, 'nombre' => 'Mouse Logitech', 'precio' => 29.99),
    3 => array('id' => 3, 'nombre' => 'Teclado Mecánico', 'precio' => 79.99),
    4 => array('id' => 4, 'nombre' => 'Monitor 24"', 'precio' => 199.99),
    5 => array('id' => 5, 'nombre' => 'Auriculares Gaming', 'precio' => 59.99),
    6 => array('id' => 6, 'nombre' => 'Webcam HD', 'precio' => 49.99),
    7 => array('id' => 7, 'nombre' => 'SSD 500GB', 'precio' => 89.99),
    8 => array('id' => 8, 'nombre' => 'Router WiFi 6', 'precio' => 129.99)
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    if ($producto_id > 0 && $cantidad > 0 && isset($productos[$producto_id])) {
        // Si el producto ya está en el carrito, incrementar cantidad
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
        } else {
            // Agregar nuevo producto al carrito
            $_SESSION['carrito'][$producto_id] = array(
                'id' => $producto_id,
                'nombre' => $productos[$producto_id]['nombre'],
                'precio' => $productos[$producto_id]['precio'],
                'cantidad' => $cantidad
            );
        }
        
        $_SESSION['mensaje'] = 'Producto agregado al carrito exitosamente';
        header('Location: carrito.php');
        exit();
    }
}

header('Location: index.php');
exit();
?>
