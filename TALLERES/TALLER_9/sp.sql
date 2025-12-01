DELIMITER //

-- Procedimiento para registrar una nueva venta
CREATE PROCEDURE sp_registrar_venta(
    IN p_cliente_id INT,
    IN p_producto_id INT,
    IN p_cantidad INT,
    OUT p_venta_id INT
)
BEGIN
    DECLARE v_precio DECIMAL(10,2);
    DECLARE v_subtotal DECIMAL(10,2);
    DECLARE v_stock INT;
    
    -- Verificar stock disponible
    SELECT stock, precio INTO v_stock, v_precio 
    FROM productos 
    WHERE id = p_producto_id;
    
    IF v_stock >= p_cantidad THEN
        -- Iniciar transacción
        START TRANSACTION;
        
        -- Calcular subtotal
        SET v_subtotal = v_precio * p_cantidad;
        
        -- Insertar venta
        INSERT INTO ventas (cliente_id, total, estado)
        VALUES (p_cliente_id, v_subtotal, 'completada');
        
        SET p_venta_id = LAST_INSERT_ID();
        
        -- Insertar detalle de venta
        INSERT INTO detalles_venta (venta_id, producto_id, cantidad, precio_unitario, subtotal)
        VALUES (p_venta_id, p_producto_id, p_cantidad, v_precio, v_subtotal);
        
        -- Actualizar stock
        UPDATE productos 
        SET stock = stock - p_cantidad 
        WHERE id = p_producto_id;
        
        -- Confirmar transacción
        COMMIT;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stock insuficiente';
    END IF;
END //

-- Procedimiento para obtener estadísticas de cliente
CREATE PROCEDURE sp_estadisticas_cliente(
    IN p_cliente_id INT
)
BEGIN
    SELECT 
        c.nombre,
        c.nivel_membresia,
        COUNT(v.id) as total_compras,
        COALESCE(SUM(v.total), 0) as total_gastado,
        COALESCE(AVG(v.total), 0) as promedio_compra,
        (SELECT GROUP_CONCAT(DISTINCT p.nombre)
         FROM ventas v2
         JOIN detalles_venta dv ON v2.id = dv.venta_id
         JOIN productos p ON dv.producto_id = p.id
         WHERE v2.cliente_id = p_cliente_id
         LIMIT 3) as ultimos_productos
    FROM clientes c
    LEFT JOIN ventas v ON c.id = v.cliente_id
    WHERE c.id = p_cliente_id
    GROUP BY c.id;
END //

-- Procedimiento para actualizar precios por categoría
CREATE PROCEDURE sp_actualizar_precios_categoria(
    IN p_categoria_id INT,
    IN p_porcentaje DECIMAL(5,2)
)
BEGIN
    DECLARE v_affected_rows INT;
    
    UPDATE productos
    SET precio = precio * (1 + p_porcentaje/100)
    WHERE categoria_id = p_categoria_id;
    
    SELECT ROW_COUNT() INTO v_affected_rows;
    
    SELECT 
        CONCAT('Se actualizaron ', v_affected_rows, ' productos. ',
               'Nuevo promedio de precios: $', 
               (SELECT AVG(precio) 
                FROM productos 
                WHERE categoria_id = p_categoria_id)
        ) as resultado;
END //

-- Procedimiento para reporte de ventas por período
CREATE PROCEDURE sp_reporte_ventas(
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    SELECT 
        DATE(v.fecha_venta) as fecha,
        COUNT(DISTINCT v.id) as total_ventas,
        COUNT(DISTINCT v.cliente_id) as total_clientes,
        SUM(v.total) as ingresos_totales,
        AVG(v.total) as ticket_promedio,
        SUM(dv.cantidad) as productos_vendidos,
        GROUP_CONCAT(DISTINCT c.nombre) as compradores
    FROM ventas v
    JOIN detalles_venta dv ON v.id = dv.venta_id
    JOIN clientes c ON v.cliente_id = c.id
    WHERE DATE(v.fecha_venta) BETWEEN p_fecha_inicio AND p_fecha_fin
    GROUP BY DATE(v.fecha_venta);
END //

DELIMITER ;

--Un procedimiento para procesar una devolución de producto que actualice el inventario y el estado de la venta.
DELIMITER //
CREATE PROCEDURE sp_procesar_devolucion(
    IN p_venta_id INT,
    IN p_producto_id INT,
    IN p_cantidad INT
)
BEGIN
    DECLARE v_stock INT;
    DECLARE v_subtotal DECIMAL(10,2);
    DECLARE v_total DECIMAL(10,2);

    -- Verificar si la venta y el producto existen en detalles_venta
    IF EXISTS (SELECT 1 FROM detalles_venta WHERE venta_id = p_venta_id AND producto_id = p_producto_id) THEN
        -- Obtener el stock actual del producto
        SELECT stock INTO v_stock FROM productos WHERE id = p_producto_id;

        -- Verificar si la cantidad a devolver es válida
        IF p_cantidad > 0 THEN
            -- Calcular el subtotal de la devolución
            SELECT precio_unitario * p_cantidad INTO v_subtotal FROM detalles_venta WHERE venta_id = p_venta_id AND producto_id = p_producto_id;

            -- Actualizar el stock del producto
            UPDATE productos SET stock = stock + p_cantidad WHERE id = p_producto_id;

            -- Actualizar el detalle de venta (restar la cantidad devuelta)
            UPDATE detalles_venta
            SET cantidad = cantidad - p_cantidad,
                subtotal = subtotal - v_subtotal
            WHERE venta_id = p_venta_id AND producto_id = p_producto_id;

            -- Actualizar el total de la venta
            SELECT SUM(subtotal) INTO v_total FROM detalles_venta WHERE venta_id = p_venta_id;
            UPDATE ventas SET total = v_total WHERE id = p_venta_id;

            -- Si el total de la venta es 0, cambiar el estado a 'devuelta'
            IF v_total = 0 THEN
                UPDATE ventas SET estado = 'devuelta' WHERE id = p_venta_id;
            END IF;
        ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cantidad de devolución inválida';
        END IF;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Venta o producto no encontrado en detalles de venta';
    END IF;
END //

--Un procedimiento para calcular y aplicar descuentos basados en el historial de compras del cliente.
DELIMITER //
CREATE PROCEDURE sp_aplicar_descuento_cliente(
    IN p_cliente_id INT
)
BEGIN
    DECLARE v_total_compras INT;
    DECLARE v_descuento DECIMAL(5,2);

    -- Obtener el total de compras del cliente
    SELECT COUNT(*) INTO v_total_compras FROM ventas WHERE cliente_id = p_cliente_id AND estado = 'completada';

    -- Calcular el descuento basado en el historial de compras
    IF v_total_compras >= 10 THEN
        SET v_descuento = 15.00;
    ELSEIF v_total_compras >= 5 THEN
        SET v_descuento = 10.00;
    ELSEIF v_total_compras >= 1 THEN
        SET v_descuento = 5.00;
    ELSE
        SET v_descuento = 0.00;
    END IF;

    -- Aplicar el descuento a las futuras compras del cliente
    UPDATE clientes
    SET nivel_membresia = CASE
        WHEN v_descuento = 15.00 THEN 'Oro'
        WHEN v_descuento = 10.00 THEN 'Plata'
        WHEN v_descuento = 5.00 THEN 'Bronce'
        ELSE 'Ninguna'
    END
    WHERE id = p_cliente_id;
END //

//Un procedimiento para generar un reporte de productos con bajo stock y sugerir cantidades de reposición.
DELIMITER //
CREATE PROCEDURE sp_reporte_bajo_stock(
    IN p_umbral_stock INT
)
BEGIN
    SELECT 
        p.id,
        p.nombre,
        p.stock,
        p.precio,
        (p.stock < p_umbral_stock) AS necesita_reposicion,
        CASE 
            WHEN p.stock < p_umbral_stock THEN (p_umbral_stock - p.stock) + 10
            ELSE 0
        END AS cantidad_sugerida_reposicion
    FROM productos p
    WHERE p.stock < p_umbral_stock;
END //
DELIMITER ;


//Un procedimiento para calcular comisiones por ventas basadas en diferentes criterios (monto total, cantidad de productos, etc.)
DELIMITER //
CREATE PROCEDURE sp_calcular_comisiones(
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    SELECT 
        v.id AS venta_id,
        v.cliente_id,
        v.total AS monto_venta,
        CASE 
            WHEN v.total >= 1000 THEN v.total * 0.10
            WHEN v.total >= 500 THEN v.total * 0.07
            WHEN v.total >= 100 THEN v.total * 0.05
            ELSE v.total * 0.02
        END AS comision
    FROM ventas v
    WHERE DATE(v.fecha_venta) BETWEEN p_fecha_inicio AND p_fecha_fin
      AND v.estado = 'completada';
END //
DELIMITER ;
