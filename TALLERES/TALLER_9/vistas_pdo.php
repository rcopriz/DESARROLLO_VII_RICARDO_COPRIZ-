<?php
require_once "config_pdo.php";
// Una vista que calcule métricas de rendimiento por categoría (ventas totales, cantidad de productos, productos más vendidos).
function mostrarRendimientoCategorias($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_metricas_categorias");

        echo "<h3>Métricas de Rendimiento por Categoría:</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Categoría</th>
                <th>Total Ventas</th>
                <th>Cantidad de Productos</th>
                <th>Producto Más Vendido</th>
                <th>Total Vendido del Producto</th>
              </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['categoria']}</td>";
            echo "<td>\${$row['ingresos_totales']}</td>";
            echo "<td>{$row['total_productos']}</td>";
            echo "<td>{$row['producto_mas_vendido']}</td>";
            echo "<td>{$row['cantidad_mas_vendida']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//Una vista que muestre el historial completo de cada cliente, incluyendo productos comprados y montos totales.
function mostrarHistorialClientes($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_historial_clientes");

        echo "<h3>Historial Completo de Clientes:</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Monto Total</th>
              </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['cliente']}</td>";
            echo "<td>{$row['producto']}</td>";
            echo "<td>{$row['cantidad']}</td>";
            echo "<td>\${$row['monto_total']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
//Una vista que muestre las tendencias de ventas por mes, incluyendo comparativas con meses anteriores.
function mostrarTendenciasVentasMensuales($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_tendencias_ventas_mensuales");

        echo "<h3>Tendencias de Ventas Mensuales:</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Total Ventas</th>
                <th>Ingresos Totales</th>
                <th>Promedio de Venta</th>
              </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['anio']}</td>";
            echo "<td>{$row['mes']}</td>";
            echo "<td>{$row['total_ventas']}</td>";
            echo "<td>\${$row['ingresos_totales']}</td>";
            echo "<td>\${$row['promedio_venta']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//Una vista que muestre los productos con bajo stock (menos de 5 unidades) junto con su información de ventas.
function mostrarProductosBajoStock($pdo) {
    try {
        $stmt = $pdo->query("SELECT p.nombre, p.stock, 
            (SELECT SUM(dv.cantidad) 
             FROM detalles_venta dv 
             WHERE dv.producto_id = p.id) as total_vendido
            FROM productos p
            WHERE p.stock < 5");

        echo "<h3>Productos con Bajo Stock (menos de 5 unidades):</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Producto</th>
                <th>Stock</th>
                <th>Total Vendido</th>
              </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['stock']}</td>";
            echo "<td>{$row['total_vendido']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function mostrarResumenCategorias($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_resumen_categorias");

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

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoria = $row['categoria'];
            $total_productos = $row['total_productos']; 
            $total_stock = $row['total_stock'];
            $precio_promedio = $row['precio_promedio'];
            $precio_minimo = $row['precio_minimo'];
            $precio_maximo = $row['precio_maximo'];
            echo "<tr>";
            echo "<td>{$categoria}</td>";
            echo "<td>{$total_productos}</td>";
            echo "<td>{$total_stock}</td>";
            echo "<td>\${$precio_promedio}</td>";
            echo "<td>\${$precio_minimo}</td>";
            echo "<td>\${$precio_maximo}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function mostrarProductosPopulares($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_productos_populares LIMIT 5");

        echo "<h3>Top 5 Productos Más Vendidos:</h3>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Total Vendido</th>
                <th>Ingresos Totales</th>
                <th>Compradores Únicos</th>
              </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producto = $row['producto'];
            $categoria = $row['categoria'];
            $total_vendido = $row['total_vendido'];
            $ingresos_totales = $row['ingresos_totales'];
            $compradores_unicos = $row['compradores_unicos'];   
            echo "<tr>";
            echo "<td>{$producto}</td>";
            echo "<td>{$categoria}</td>";
            echo "<td>{$total_vendido}</td>";
            echo "<td>\${$ingresos_totales}</td>";
            echo "<td>{$compradores_unicos}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Mostrar los resultados
mostrarResumenCategorias($pdo);
mostrarProductosPopulares($pdo);

mostrarProductosBajoStock($pdo);
mostrarHistorialClientes($pdo);
mostrarRendimientoCategorias($pdo);
mostrarTendenciasVentasMensuales($pdo);
$pdo = null;
?>