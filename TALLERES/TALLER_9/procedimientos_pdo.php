<?php
require_once "config_pdo.php";

// Función para registrar una venta
function registrarVenta($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:cliente_id, :producto_id, :cantidad, @venta_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Obtener el ID de la venta
        $result = $pdo->query("SELECT @venta_id as venta_id")->fetch(PDO::FETCH_ASSOC);
        
        echo "Venta registrada con éxito. ID de venta: " . $result['venta_id'];
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_estadisticas_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//funcion para Un procedimiento para procesar una devolución de producto que actualice el inventario y el estado de la venta.
function procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_procesar_devolucion(:venta_id, :producto_id, :cantidad)");
        $stmt->bindParam(':venta_id', $venta_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        echo "Devolución procesada con éxito para la venta ID: " . $venta_id;
    } catch (PDOException $e) {
        echo "Error al procesar la devolución: " . $e->getMessage();
    }
}

//Una Funcion Un procedimiento para calcular y aplicar descuentos basados en el historial de compras del cliente.   
function aplicarDescuentoCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_aplicar_descuento_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        echo "<br>Descuento aplicado con éxito para el cliente ID: " . $cliente_id;
    } catch (PDOException $e) {
        echo "<br>Error al aplicar el descuento: " . $e->getMessage();
    }
}

//una funcion para Un procedimiento para generar un reporte de productos con bajo stock y sugerir cantidades de reposición.
function reporteBajoStock($pdo, $umbral) {
    try {
        $stmt = $pdo->prepare("CALL sp_reporte_bajo_stock(:umbral)");
        $stmt->bindParam(':umbral', $umbral, PDO::PARAM_INT);
        $stmt->execute();
        
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Reporte de Productos con Bajo Stock (Reposición)</h3>";
        foreach ($productos as $producto) {
            echo "Producto ID: " . $producto['id'] . " - Nombre: " . $producto['nombre'] . " - Stock Actual: " . $producto['stock'] . " - Cantidad Sugerida para Reposición: " . $producto['cantidad_sugerida_reposicion'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error al generar el reporte: " . $e->getMessage();
    }
}

//una funcion Un procedimiento para calcular comisiones por ventas basadas en diferentes criterios (monto total, cantidad de productos, etc.)
function calcularComisiones($pdo, $fecha_inicio, $fecha_fin) {
    try {
        $stmt = $pdo->prepare("CALL sp_calcular_comisiones(:fecha_inicio, :fecha_fin)");
        $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
        $stmt->execute();
        
        $comisiones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Comisiones por Ventas</h3>";
        foreach ($comisiones as $comision) {
            echo "Venta ID: " . $comision['venta_id'] . " - Cliente ID: " . $comision['cliente_id'] . " - Monto Venta: $" . $comision['monto_venta'] . " - Comisión: $" . $comision['comision'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error al calcular comisiones: " . $e->getMessage();
    }
}   


// Ejemplos de uso
registrarVenta($pdo, 1, 1, 2);
obtenerEstadisticasCliente($pdo, 1);
procesarDevolucion($pdo, 1, 1, 1);
aplicarDescuentoCliente($pdo, 1);
reporteBajoStock($pdo, 5);
calcularComisiones($pdo, '2025-01-01', '2025-12-31');
$pdo = null;
?>