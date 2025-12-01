<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

//funcion para Un procedimiento para procesar una devolución de producto que actualice el inventario y el estado de la venta.
function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        echo "Devolución procesada con éxito para la venta ID: " . $venta_id;
    } catch (Exception $e) {
        echo "Error al procesar la devolución: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

//Una Funcion Un procedimiento para calcular y aplicar descuentos basados en el historial de compras del cliente.   
function aplicarDescuentoCliente($conn, $cliente_id) {
    $query = "CALL sp_aplicar_descuento_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    try {
        mysqli_stmt_execute($stmt);
        
        echo "<br>Descuento aplicado con éxito para el cliente ID: " . $cliente_id;
    } catch (Exception $e) {
        echo "<br>Error al aplicar el descuento: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}
//una funcion para Un procedimiento para generar un reporte de productos con bajo stock y sugerir cantidades de reposición.
function reporteBajoStock($conn, $umbral) {
    $query = "CALL sp_reporte_bajo_stock(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $umbral);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $productos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        echo "<h3>Reporte de Productos con Bajo Stock</h3>";
        foreach ($productos as $producto) {
            echo "Producto ID: " . $producto['id'] . " - Nombre: " . $producto['nombre'] . " - Stock Actual: " . $producto['stock'] . " - Cantidad Sugerida para Reposición: " . $producto['cantidad_sugerida_reposicion'] . "<br>";
        }
    }
    
    mysqli_stmt_close($stmt);
}
//una funcion para Un procedimiento para generar un reporte de productos con bajo stock y sugerir cantidades de reposición.
function reporteBajoStockReposicion($conn, $umbral) {
    $query = "CALL sp_reporte_bajo_stock(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $umbral);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $productos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        echo "<h3>Reporte de Productos con Bajo Stock (Reposición)</h3>";
        foreach ($productos as $producto) {
            echo "Producto ID: " . $producto['id'] . " - Nombre: " . $producto['nombre'] . " - Stock Actual: " . $producto['stock'] . " - Cantidad Sugerida para Reposición: " . $producto['cantidad_sugerida_reposicion'] . "<br>";
        }
    }
    
    mysqli_stmt_close($stmt);
}


//una funcion Un procedimiento para calcular comisiones por ventas basadas en diferentes criterios (monto total, cantidad de productos, etc.)
function calcularComisiones($conn, $fecha_inicio, $fecha_fin) {
    $query = "CALL sp_calcular_comisiones(?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $fecha_inicio, $fecha_fin);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $comisiones = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        echo "<h3>Comisiones por Ventas</h3>";
        foreach ($comisiones as $comision) {
            echo "Vendedor ID: " . $comision['vendedor_id'] . " - Nombre: " . $comision['nombre'] . " - Total Ventas: $" . $comision['total_ventas'] . " - Comisión: $" . $comision['comision'] . "<br>";
        }
    }
    
    mysqli_stmt_close($stmt);
}
// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);
procesarDevolucion($conn, 1, 1, 1);
aplicarDescuentoCliente($conn, 1);
reporteBajoStock($conn, 5);
reporteBajoStockReposicion($conn, 5);
calcularComisiones($conn, '2025-01-01', '2025-12-31');
mysqli_close($conn);
?>