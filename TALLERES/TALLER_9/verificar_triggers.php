<?php
require_once "config_pdo.php"; // O usar mysqli según prefieras

function verificarCambiosPrecio($pdo, $producto_id, $nuevo_precio) {
    try {
        // Actualizar precio
        $stmt = $pdo->prepare("UPDATE productos SET precio = ? WHERE id = ?");
        $stmt->execute([$nuevo_precio, $producto_id]);
        
        // Verificar log de cambios
        $stmt = $pdo->prepare("SELECT * FROM historial_precios WHERE producto_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Cambio de Precio Registrado:</h3>";
        echo "Precio anterior: $" . $log['precio_anterior'] . "<br>";
        echo "Precio nuevo: $" . $log['precio_nuevo'] . "<br>";
        echo "Fecha del cambio: " . $log['fecha_cambio'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarMovimientoInventario($pdo, $producto_id, $nueva_cantidad) {
    try {
        // Actualizar stock
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_id]);
        
        // Verificar movimientos de inventario
        $stmt = $pdo->prepare("
            SELECT * FROM movimientos_inventario 
            WHERE producto_id = ? 
            ORDER BY fecha_movimiento DESC LIMIT 1
        ");
        $stmt->execute([$producto_id]);
        $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Movimiento de Inventario Registrado:</h3>";
        echo "Tipo de movimiento: " . $movimiento['tipo_movimiento'] . "<br>";
        echo "Cantidad: " . $movimiento['cantidad'] . "<br>";
        echo "Stock anterior: " . $movimiento['stock_anterior'] . "<br>";
        echo "Stock nuevo: " . $movimiento['stock_nuevo'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//funcion para Un trigger que verifique y actualice automáticamente el nivel de membresía de un cliente basado en su historial de compras.
function verificarNivelMembresia($pdo, $cliente_id) {
    try {
        // Supongamos que el trigger ya está implementado en la base de datos.
        // Aquí solo verificamos el nivel de membresía actual.
        $stmt = $pdo->prepare("SELECT nivel_membresia FROM clientes WHERE id = ?");
        $stmt->execute([$cliente_id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Nivel de Membresía del Cliente ID " . $cliente_id . ":</h3>";
        echo "Nivel de Membresía: " . $cliente['nivel_membresia'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//funcion para Un trigger que mantenga una tabla de estadísticas actualizada con el total de ventas por categoría.
function verificarEstadisticasCategorias($pdo, $categoria_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM estadisticas_categorias WHERE categoria_id = ?");
        $stmt->execute([$categoria_id]);
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas de la Categoría ID " . $categoria_id . ":</h3>";
        echo "Total de Ventas: " . $estadisticas['total_ventas'] . "<br>";
        echo "Ingresos Totales: $" . $estadisticas['ingresos_totales'] . "<br>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


//una funcion para Un trigger que envíe alertas cuando el stock de un producto llegue a un nivel crítico.
function reporteBajoStockNivelCritico($pdo, $umbral) {
    try {
        $stmt = $pdo->prepare("select * from alertas_stock");
       // $stmt->bindParam(':umbral', $umbral, PDO::PARAM_INT);
        $stmt->execute();
        
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Reporte de Productos con Stock Critico</h3>";
        foreach ($productos as $producto) {
            echo "Producto ID: " . $producto['id'] . " - Nombre: " . $producto['nombre'] . " - Stock Actual: " . $producto['stock'] . " - Cantidad Sugerida para Reposición: " . $producto['cantidad_sugerida_reposicion'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error al generar el reporte: " . $e->getMessage();
    }
}
// Probar los triggers
verificarCambiosPrecio($pdo, 1, 999.99);
verificarMovimientoInventario($pdo, 1, 15);
verificarNivelMembresia($pdo, 2);
verificarEstadisticasCategorias($pdo, 2);
reporteBajoStockNivelCritico($pdo, 5);
$pdo = null;
?>