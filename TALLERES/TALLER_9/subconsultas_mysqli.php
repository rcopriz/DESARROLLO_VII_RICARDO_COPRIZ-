<?php
require_once "config_mysqli.php";

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

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = $row['nombre'];
        $precio = $row['precio'];
        $categoria = $row['categoria'];
        $promedio_categoria = $row['promedio_categoria'];
        echo "Producto: $nombre, Precio: $$precio, ";
        echo "Categoría: $categoria, Promedio categoría: $$promedio_categoria<br>";
    }
    mysqli_free_result($result);
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

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = $row['nombre'];
        $total_compras = $row['total_compras'];
        $promedio_ventas = $row['promedio_ventas'];
        echo "Cliente: $nombre, Total compras: $$total_compras, ";
        echo "Promedio general: $$promedio_ventas<br>";
    }
    mysqli_free_result($result);
}
/*
$sql = "SELECT p.* 
FROM productos as p 
RIGHT OUTER JOIN detalles_venta as v on p.id = v.producto_id";
*/
// 3. Productos que no han sido vendidos
$sql = "SELECT p.nombre, p.precio 
        FROM productos as p 
        WHERE p.id NOT IN (
            SELECT v.producto_id 
            FROM detalles_venta as v
        )";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<h3>Productos con no vendidos:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = $row['nombre'];
        $precio = $row['precio'];
        echo "Producto: $nombre, Precio: $$precio<br>";
    }
    mysqli_free_result($result);

//Listar las categorías con el número de productos y el valor total del inventario.
    $sql = "SELECT c.nombre as categoria, 
            COUNT(p.id) as numero_productos, 
            SUM(p.precio) as valor_total_inventario
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id, c.nombre";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            $categoria = $row['categoria'];
            $numero_productos = $row['numero_productos'];
            $valor_total_inventario = $row['valor_total_inventario'];
            echo "Categoría: $categoria, Número de productos: $numero_productos, ";
            echo "Valor total del inventario: $$valor_total_inventario<br>";
        }
        mysqli_free_result($result);
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
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<h3>Clientes que han comprado todos los productos de la categoría específica: 1</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row['nombre'];
            $email = $row['email'];
            echo "Cliente: $nombre, Email: $email<br>";
        }
        mysqli_free_result($result);
    }

//Calcular el porcentaje de ventas de cada producto respecto al total de ventas.
    $sql = "SELECT p.nombre, 
            SUM(dv.cantidad * dv.precio_unitario) as total_ventas_producto,
            (SELECT SUM(cantidad * precio_unitario) FROM detalles_venta) as total_ventas_general,
            (SUM(dv.cantidad * dv.precio_unitario) / (SELECT SUM(cantidad * precio_unitario) FROM detalles_venta)) * 100 as porcentaje_ventas
            FROM productos p
            JOIN detalles_venta dv ON p.id = dv.producto_id
            GROUP BY p.id, p.nombre";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row['nombre'];
            $total_ventas_producto = $row['total_ventas_producto'];
            $porcentaje_ventas = $row['porcentaje_ventas'];
            echo "Producto: $nombre, Total ventas: $$total_ventas_producto, ";
            echo "Porcentaje de ventas: " . number_format($porcentaje_ventas, 2) . "%<br>";
        }
        mysqli_free_result($result);
    }
}
mysqli_close($conn);
?>