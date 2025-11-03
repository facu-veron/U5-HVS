<?php
session_start();

// Productos completos
$productos = array(
    array('id' => 1, 'nombre' => 'Laptop HP', 'precio' => 899.99, 'descripcion' => 'Laptop de alto rendimiento', 'stock' => 10),
    array('id' => 2, 'nombre' => 'Mouse Logitech', 'precio' => 29.99, 'descripcion' => 'Mouse inalámbrico ergonómico', 'stock' => 25),
    array('id' => 3, 'nombre' => 'Teclado Mecánico', 'precio' => 79.99, 'descripcion' => 'Teclado mecánico RGB', 'stock' => 15),
    array('id' => 4, 'nombre' => 'Monitor 24"', 'precio' => 199.99, 'descripcion' => 'Monitor Full HD 24 pulgadas', 'stock' => 8),
    array('id' => 5, 'nombre' => 'Auriculares Gaming', 'precio' => 59.99, 'descripcion' => 'Auriculares con micrófono', 'stock' => 20),
    array('id' => 6, 'nombre' => 'Webcam HD', 'precio' => 49.99, 'descripcion' => 'Webcam 1080p', 'stock' => 12),
    array('id' => 7, 'nombre' => 'SSD 500GB', 'precio' => 89.99, 'descripcion' => 'Disco sólido de alta velocidad', 'stock' => 30),
    array('id' => 8, 'nombre' => 'Router WiFi 6', 'precio' => 129.99, 'descripcion' => 'Router de última generación', 'stock' => 5)
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - TechStore</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 id="logo">TechStore</h1>
            <nav>
                <ul>
                    <li><a href="index.php" id="nav-inicio">Inicio</a></li>
                    <li><a href="productos.php" id="nav-productos">Productos</a></li>
                    <li><a href="carrito.php" id="nav-carrito">Carrito (<?php echo count($_SESSION['carrito']); ?>)</a></li>
                    <li><a href="contacto.php" id="nav-contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>Todos Nuestros Productos</h1>
        
        <div class="filtros">
            <input type="text" id="buscar-producto" placeholder="Buscar productos...">
            <select id="ordenar-precio">
                <option value="">Ordenar por precio</option>
                <option value="asc">Menor a Mayor</option>
                <option value="desc">Mayor a Menor</option>
            </select>
        </div>

        <div class="productos-grid" id="lista-productos">
            <?php foreach ($productos as $producto): ?>
            <div class="producto-card" data-producto-id="<?php echo $producto['id']; ?>">
                <div class="producto-imagen">
                    <img src="images/placeholder.png" alt="<?php echo $producto['nombre']; ?>">
                </div>
                <h3 class="producto-nombre"><?php echo $producto['nombre']; ?></h3>
                <p class="producto-descripcion"><?php echo $producto['descripcion']; ?></p>
                <p class="producto-precio">$<?php echo number_format($producto['precio'], 2); ?></p>
                <p class="producto-stock">Stock: <?php echo $producto['stock']; ?> unidades</p>
                <form action="agregar_carrito.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo $producto['stock']; ?>" class="cantidad-input">
                    <button type="submit" class="btn-agregar">Agregar al Carrito</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 TechStore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
