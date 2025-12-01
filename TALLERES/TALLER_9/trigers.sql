
DELIMITER //

-- Trigger para auditar cambios en productos
CREATE TRIGGER tr_productos_update
AFTER UPDATE ON productos
FOR EACH ROW
BEGIN
    IF OLD.precio != NEW.precio THEN
        INSERT INTO log_productos (producto_id, accion, campo_modificado, valor_anterior, valor_nuevo, usuario)
        VALUES (NEW.id, 'UPDATE', 'precio', OLD.precio, NEW.precio, CURRENT_USER());
        
        INSERT INTO historial_precios (producto_id, precio_anterior, precio_nuevo, usuario)
        VALUES (NEW.id, OLD.precio, NEW.precio, CURRENT_USER());
    END IF;
    
    IF OLD.stock != NEW.stock THEN
        INSERT INTO log_productos (producto_id, accion, campo_modificado, valor_anterior, valor_nuevo, usuario)
        VALUES (NEW.id, 'UPDATE', 'stock', OLD.stock, NEW.stock, CURRENT_USER());
        
        INSERT INTO movimientos_inventario (
            producto_id,
            tipo_movimiento,
            cantidad,
            motivo,
            stock_anterior,
            stock_nuevo
        )
        VALUES (
            NEW.id,
            CASE 
                WHEN NEW.stock > OLD.stock THEN 'ENTRADA'
                ELSE 'SALIDA'
            END,
            ABS(NEW.stock - OLD.stock),
            'Actualización de stock',
            OLD.stock,
            NEW.stock
        );
    END IF;
END //

-- Trigger para validar stock antes de actualizar
CREATE TRIGGER tr_validar_stock
BEFORE UPDATE ON productos
FOR EACH ROW
BEGIN
    IF NEW.stock < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El stock no puede ser negativo';
    END IF;
END //

-- Trigger para auditar ventas
CREATE TRIGGER tr_ventas_update
AFTER UPDATE ON ventas
FOR EACH ROW
BEGIN
    INSERT INTO log_ventas (venta_id, accion, estado_anterior, estado_nuevo, usuario)
    VALUES (NEW.id, 'UPDATE', OLD.estado, NEW.estado, CURRENT_USER());
    
    -- Si la venta se cancela, restaurar el stock
    IF NEW.estado = 'cancelada' AND OLD.estado != 'cancelada' THEN
        UPDATE productos p
        JOIN detalles_venta dv ON p.id = dv.producto_id
        SET p.stock = p.stock + dv.cantidad
        WHERE dv.venta_id = NEW.id;
    END IF;
END //

-- Trigger para nuevos productos
CREATE TRIGGER tr_nuevos_productos
AFTER INSERT ON productos
FOR EACH ROW
BEGIN
    INSERT INTO log_productos (producto_id, accion, campo_modificado, valor_nuevo, usuario)
    VALUES (NEW.id, 'INSERT', 'nuevo_producto', NEW.nombre, CURRENT_USER());
    
    -- Si el stock inicial es mayor que 0, registrar como entrada de inventario
    IF NEW.stock > 0 THEN
        INSERT INTO movimientos_inventario (
            producto_id,
            tipo_movimiento,
            cantidad,
            motivo,
            stock_anterior,
            stock_nuevo
        )
        VALUES (
            NEW.id,
            'ENTRADA',
            NEW.stock,
            'Stock inicial',
            0,
            NEW.stock
        );
    END IF;
END //

DELIMITER ;

--Un trigger que verifique y actualice automáticamente el nivel de membresía de un cliente basado en su historial de compras.
DELIMITER //
CREATE TRIGGER trg_actualizar_nivel_membresia
AFTER INSERT ON ventas
FOR EACH ROW
BEGIN
    DECLARE v_total_compras INT;
    DECLARE v_descuento DECIMAL(5,2);
    
    SELECT COUNT(*) INTO v_total_compras
    FROM ventas
    WHERE cliente_id = NEW.cliente_id AND estado = 'completada';

    IF v_total_compras >= 10 THEN
        SET v_descuento = 15.00;
    ELSEIF v_total_compras >= 5 THEN
        SET v_descuento = 10.00;
    ELSEIF v_total_compras >= 1 THEN
        SET v_descuento = 5.00;
    ELSE
        SET v_descuento = 0.00;
    END IF;

    UPDATE clientes
    SET nivel_membresia = CASE
        WHEN v_descuento = 15.00 THEN 'Oro'
        WHEN v_descuento = 10.00 THEN 'Plata'
        WHEN v_descuento = 5.00 THEN 'Bronce'
        ELSE 'Ninguna'
    END
    WHERE id = NEW.cliente_id;
END;
//
DELIMITER ;


-- tabla estadisticas_categorias
CREATE TABLE estadisticas_categorias (
    categoria_id INT PRIMARY KEY,
    total_ventas INT DEFAULT 0,
    ingresos_totales DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);


--Un trigger que mantenga una tabla de estadísticas actualizada con el total de ventas por categoría.
DELIMITER //
CREATE TRIGGER trg_actualizar_estadisticas_categorias
AFTER INSERT ON detalles_venta
FOR EACH ROW
BEGIN
    DECLARE v_categoria_id INT;
    
    SELECT p.categoria_id INTO v_categoria_id
    FROM productos p
    WHERE p.id = NEW.producto_id;

    INSERT INTO estadisticas_categorias (categoria_id, total_ventas, ingresos_totales)
    VALUES (v_categoria_id, NEW.cantidad, NEW.subtotal)
    ON DUPLICATE KEY UPDATE
        total_ventas = total_ventas + NEW.cantidad,
        ingresos_totales = ingresos_totales + NEW.subtotal;
END;
//
DELIMITER ;

-- tabla alertas_stock
CREATE TABLE alertas_stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT,
    mensaje VARCHAR(255),
    fecha_alerta DATETIME,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

--Un trigger que envíe alertas cuando el stock de un producto llegue a un nivel crítico.
DELIMITER //
CREATE TRIGGER trg_alerta_stock_critico
AFTER UPDATE ON productos
FOR EACH ROW
BEGIN
    IF NEW.stock < 5 AND OLD.stock >= 5 THEN
        INSERT INTO alertas_stock (producto_id, mensaje, fecha_alerta)
        VALUES (NEW.id, CONCAT('Stock crítico para el producto: ', NEW.nombre, '. Stock actual: ', NEW.stock), NOW());
    END IF;
END;
//
DELIMITER ;


--Un trigger que mantenga un historial de cambios de estado de los clientes (activo/inactivo).
DELIMITER //
CREATE TRIGGER trg_historial_estado_clientes
AFTER UPDATE ON clientes
FOR EACH ROW
BEGIN
    IF OLD.estado != NEW.estado THEN
        INSERT INTO historial_estado_clientes (cliente_id, estado_anterior, estado_nuevo, fecha_cambio, usuario)
        VALUES (NEW.id, OLD.estado, NEW.estado, NOW(), CURRENT_USER());
    END IF;
END;
//
DELIMITER ;