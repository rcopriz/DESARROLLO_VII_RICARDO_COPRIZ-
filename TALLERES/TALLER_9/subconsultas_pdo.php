
<?php
require_once "config_pdo.php";

try {
    // 1. Productos que tienen un precio mayor al promedio de su categoría
    $sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
            (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE p.precio > (
                SELECT AVG(precio)
                FROM productos p2
                WHERE p2.categoria_id = p.categoria_id
            )";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombre = $row['nombre'];
        $precio = $row['precio']; 
        $categoria = $row['categoria'];
        $promedio_categoria = $row['promedio_categoria'];
        echo "Producto: {$nombre}, Precio: \${$precio}, ";
        echo "Categoría: {$categoria}, Promedio categoría: \${$promedio_categoria}<br>";
    }

    // 2. Clientes con compras superiores al promedio
    $sql = "SELECT c.nombre, c.email,
            (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) as total_compras,
            (SELECT AVG(total) FROM ventas) as promedio_ventas
            FROM clientes c
            WHERE (
                SELECT SUM(total)
                FROM ventas
                WHERE cliente_id = c.id
            ) > (
                SELECT AVG(total)
                FROM ventas
            )";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombre = $row['nombre'];
        $total_compras = $row['total_compras']; 
        $promedio_ventas = $row['promedio_ventas'];
        echo "Cliente: {$nombre}, Total compras: \${$total_compras}, ";
        echo "Promedio general: \${$promedio_ventas}<br>";
    }

    // 3. Productos que no han sido vendidos
    $sql = "SELECT p.nombre, p.precio 
            FROM productos as p 
            WHERE p.id NOT IN (
                SELECT v.producto_id 
                FROM detalles_venta as v
            )";
    $stmt = $pdo->query($sql);
    echo "<h3>Productos con no vendidos:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombre = $row['nombre'];
        $precio = $row['precio'];
        echo "Producto: {$nombre}, Precio: \${$precio}<br>";
    }

    //Listar las categorías con el número de productos y el valor total del inventario.
    $sql = "SELECT c.nombre as categoria, 
            COUNT(p.id) as numero_productos, 
            SUM(p.precio) as valor_total_inventario
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id, c.nombre";
    $stmt = $pdo->query($sql);
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Categoría: {$row['categoria']}, Número de productos: {$row['numero_productos']}, ";
        echo "Valor total del inventario: \${$row['valor_total_inventario']}<br>";
    }

    //Encontrar los clientes que han comprado todos los productos de una categoría específica.
    $categoria_especifica_id = 1; 
    $sql = "SELECT c.nombre, c.email
            FROM clientes c
            WHERE NOT EXISTS (
                SELECT p.id
                FROM productos p
                WHERE p.categoria_id = $categoria_especifica_id
                AND NOT EXISTS (
                    SELECT v.producto_id
                    FROM ventas ve
                    JOIN detalles_venta v ON ve.id = v.venta_id
                    WHERE ve.cliente_id = c.id
                    AND v.producto_id = p.id
                )
            )";
    $stmt = $pdo->query($sql);
    echo "<h3>Clientes que han comprado todos los productos de la categoría específica: 1</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}, Email: {$row['email']}<br>";
    }

    //Calcular el porcentaje de ventas de cada producto respecto al total de ventas. 
    $sql = "SELECT p.nombre,    
            (SELECT SUM(v.cantidad * v.precio_unitario) 
             FROM detalles_venta v 
             WHERE v.producto_id = p.id) as ventas_producto,
            (SELECT SUM(v2.cantidad * v2.precio_unitario) 
             FROM detalles_venta v2) as ventas_totales
            FROM productos p";
    $stmt = $pdo->query($sql);

    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
        $porcentaje_ventas = ($row['ventas_totales'] > 0) ? 
            ($row['ventas_producto'] / $row['ventas_totales']) * 100 : 0;
        echo "Producto: {$row['nombre']}, Porcentaje de ventas: " . number_format($porcentaje_ventas, 2) . "%<br>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>