<?php
require_once "config_mysqli.php";

//Una vista que muestre las tendencias de ventas por mes, incluyendo comparativas con meses anteriores.
function mostrarTendenciasVentasMensuales($conn) {
    $sql = "SELECT * FROM vista_tendencias_ventas_mensuales";
    $result = mysqli_query($conn, $sql);
    echo "<h3>Tendencias de Ventas Mensuales:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Año</th>
            <th>Mes</th>
            <th>Total Ventas</th>
            <th>Ingresos Totales</th>
            <th>Promedio de Venta</th>
          </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $anio = $row['anio'];
        $mes = $row['mes'];
        $total_ventas = $row['total_ventas'];
        $ingresos_totales = $row['ingresos_totales'];
        $promedio_venta = $row['promedio_venta'];
        echo "<tr>";
        echo "<td>$anio</td>";
        echo "<td>$mes</td>";
        echo "<td>$total_ventas</td>";
        echo "<td>$$ingresos_totales</td>";
        echo "<td>$$promedio_venta</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

//Una vista que calcule métricas de rendimiento por categoría (ventas totales, cantidad de productos, productos más vendidos).
function mostrarCategoriasRendimiento($conn) {
    $sql = "SELECT * FROM vista_metricas_categorias";
    $result = mysqli_query($conn, $sql);
    echo "<h3>Métricas de Rendimiento por Categoría:</h3>";
    echo "<table border='1'>";  
    echo "<tr>
            <th>Categoría</th>
            <th>Total Ventas</th>
            <th>Cantidad de Productos</th>
            <th>Producto Más Vendido</th>
            <th>Total Vendido del Producto</th>
          </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $categoria = $row['categoria']; 
        $total_ventas = $row['ingresos_totales'];
        $cantidad_productos = $row['total_productos'];
        $producto_mas_vendido = $row['producto_mas_vendido'];
        $total_vendido = $row['cantidad_mas_vendida'];
        echo "<tr>";
        echo "<td>$categoria</td>";
        echo "<td>$$total_ventas</td>";
        echo "<td>$cantidad_productos</td>";
        echo "<td>$producto_mas_vendido</td>";
        echo "<td>$total_vendido</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

// vista que muestre el historial completo de cada cliente, incluyendo productos comprados y montos totales.

function mostrarHistorialClientes($conn) {  
    $sql = "SELECT c.nombre as cliente, p.nombre as producto, dv.cantidad, (dv.cantidad * dv.precio_unitario) as monto_total
            FROM clientes c
            JOIN ventas v ON c.id = v.cliente_id
            JOIN detalles_venta dv ON v.id = dv.venta_id
            JOIN productos p ON dv.producto_id = p.id
            ORDER BY c.nombre";

    $result = mysqli_query($conn, $sql);

    echo "<h3>Historial Completo de Clientes:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Monto Total</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $cliente = $row['cliente'];
        $producto = $row['producto'];
        $cantidad = $row['cantidad'];
        $monto_total = $row['monto_total'];
        echo "<tr>";
        echo "<td>$cliente</td>";
        echo "<td>$producto</td>";
        echo "<td>$cantidad</td>";
        echo "<td>$$monto_total</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}


//vista que muestre los productos con bajo stock (menos de 5 unidades) junto con su información de ventas.
function mostrarProductosBajoStock($conn) {
    $sql = "SELECT p.nombre, p.stock, 
            (SELECT SUM(dv.cantidad) 
             FROM detalles_venta dv 
             WHERE dv.producto_id = p.id) as total_vendido
            FROM productos p
            WHERE p.stock < 5";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Productos con Bajo Stock (menos de 5 unidades):</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Stock</th>
            <th>Total Vendido</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = $row['nombre'];
        $stock = $row['stock']; 
        $total_vendido = $row['total_vendido'];
        echo "<tr>";
        echo "<td>$nombre</td>";
        echo "<td>$stock</td>";
        echo "<td>$total_vendido</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

function mostrarResumenCategorias($conn) {
    $sql = "SELECT * FROM vista_resumen_categorias";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Resumen por Categorías:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Stock Total</th>
            <th>Precio Promedio</th>
            <th>Precio Mínimo</th>
            <th>Precio Máximo</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $categoria = $row['categoria'];
        $total_productos = $row['total_productos']; 
        $total_stock = $row['total_stock'];
        $precio_promedio = $row['precio_promedio'];
        $precio_minimo = $row['precio_minimo'];
        $precio_maximo = $row['precio_maximo'];
        echo "<tr>";
        echo "<td>$categoria</td>";
        echo "<td>$total_productos</td>";
        echo "<td>$total_stock</td>";
        echo "<td>$$precio_promedio</td>";
        echo "<td>$$precio_minimo</td>";
        echo "<td>$$precio_maximo</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

function mostrarProductosPopulares($conn) {
    $sql = "SELECT * FROM vista_productos_populares LIMIT 5";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Top 5 Productos Más Vendidos:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Total Vendido</th>
            <th>Ingresos Totales</th>
            <th>Compradores Únicos</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $producto = $row['producto'];
        $categoria = $row['categoria'];
        $total_vendido = $row['total_vendido'];
        $ingresos_totales = $row['ingresos_totales'];
        $compradores_unicos = $row['compradores_unicos'];   
        
        echo "<tr>";
        echo "<td>$producto</td>";
        echo "<td>$categoria</td>";
        echo "<td>$total_vendido</td>";
        echo "<td>$$ingresos_totales</td>";
        echo "<td>$compradores_unicos</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

// Mostrar los resultados
mostrarResumenCategorias($conn);
mostrarProductosPopulares($conn);

mostrarProductosBajoStock($conn);
mostrarHistorialClientes($conn);
mostrarCategoriasRendimiento($conn);
mostrarTendenciasVentasMensuales($conn);
mysqli_close($conn);
?>
