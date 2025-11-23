
-- Vista para resumen de productos por categoría
CREATE VIEW vista_resumen_categorias AS
SELECT 
    c.nombre AS categoria,
    COUNT(p.id) AS total_productos,
    SUM(p.stock) AS total_stock,
    ROUND(AVG(p.precio), 2) AS precio_promedio,
    MIN(p.precio) AS precio_minimo,
    MAX(p.precio) AS precio_maximo
FROM categorias c
LEFT JOIN productos p ON c.id = p.categoria_id
GROUP BY c.id, c.nombre;

-- Vista para detalles de ventas completas
CREATE VIEW vista_detalles_ventas AS
SELECT 
    v.id AS venta_id,
    c.nombre AS cliente,
    c.email AS cliente_email,
    p.nombre AS producto,
    dv.cantidad,
    dv.precio_unitario,
    dv.subtotal,
    v.fecha_venta,
    v.estado
FROM ventas v
JOIN clientes c ON v.cliente_id = c.id
JOIN detalles_venta dv ON v.id = dv.venta_id
JOIN productos p ON dv.producto_id = p.id;

-- Vista para productos más vendidos
CREATE VIEW vista_productos_populares AS
SELECT 
    p.id,
    p.nombre AS producto,
    p.precio,
    cat.nombre AS categoria,
    SUM(dv.cantidad) AS total_vendido,
    SUM(dv.subtotal) AS ingresos_totales,
    COUNT(DISTINCT v.cliente_id) AS compradores_unicos
FROM productos p
JOIN categorias cat ON p.categoria_id = cat.id
LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
LEFT JOIN ventas v ON dv.venta_id = v.id
GROUP BY p.id, p.nombre, p.precio, cat.nombre
ORDER BY total_vendido DESC;

-- Vista para rendimiento de clientes
CREATE VIEW vista_rendimiento_clientes AS
SELECT 
    c.id,
    c.nombre,
    c.email,
    c.nivel_membresia,
    COUNT(v.id) AS total_compras,
    SUM(v.total) AS total_gastado,
    ROUND(AVG(v.total), 2) AS promedio_compra,
    MAX(v.fecha_venta) AS ultima_compra
FROM clientes c
LEFT JOIN ventas v ON c.id = v.cliente_id AND v.estado = 'completada'
GROUP BY c.id, c.nombre, c.email, c.nivel_membresia;

-- Una vista que muestre los productos con bajo stock (menos de 5 unidades) junto con su información de ventas.
CREATE VIEW vista_productos_bajo_stock AS
SELECT 
    p.id,
    p.nombre AS producto,
    p.precio,
    p.stock,
    cat.nombre AS categoria,
    COALESCE(SUM(dv.cantidad), 0) AS total_vendido,
    COALESCE(SUM(dv.subtotal), 0) AS ingresos_totales
FROM productos p
JOIN categorias cat ON p.categoria_id = cat.id
LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
WHERE p.stock < 5
GROUP BY p.id, p.nombre, p.precio, p.stock, cat.nombre
ORDER BY p.stock ASC;

--Una vista que muestre el historial completo de cada cliente, incluyendo productos comprados y montos totales.
CREATE VIEW vista_historial_clientes AS
SELECT 
    c.id AS cliente_id,
    c.nombre AS cliente,
    c.email AS cliente_email,
    v.id AS venta_id,
    v.fecha_venta,
    v.total AS monto_total,
    p.nombre AS producto,
    dv.cantidad,
    dv.precio_unitario,
    dv.subtotal
FROM clientes c
JOIN ventas v ON c.id = v.cliente_id
JOIN detalles_venta dv ON v.id = dv.venta_id
JOIN productos p ON dv.producto_id = p.id;


--Una vista que calcule métricas de rendimiento por categoría (ventas totales, cantidad de productos, productos más vendidos).
CREATE VIEW vista_metricas_categorias AS
SELECT 
    cat.id AS categoria_id,
    cat.nombre AS categoria,
    COUNT(p.id) AS total_productos,
    COALESCE(SUM(dv.cantidad), 0) AS total_vendido,
    COALESCE(SUM(dv.subtotal), 0) AS ingresos_totales,
    p_mas_vendido.nombre AS producto_mas_vendido,
    MAX(p_mas_vendido.total_vendido) AS cantidad_mas_vendida
FROM categorias cat
LEFT JOIN productos p ON cat.id = p.categoria_id
LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
LEFT JOIN (
    SELECT 
        p.id,
        p.nombre,
        SUM(dv.cantidad) AS total_vendido
    FROM productos p
    LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
    GROUP BY p.id, p.nombre
) AS p_mas_vendido ON p.categoria_id = cat.id AND p.id = p_mas_vendido.id   
GROUP BY cat.id, cat.nombre;

-- Una vista que muestre las tendencias de ventas por mes, incluyendo comparativas con meses anteriores.
CREATE VIEW vista_tendencias_ventas_mensuales AS
SELECT 
    YEAR(v.fecha_venta) AS anio,
    MONTH(v.fecha_venta) AS mes,
    COUNT(v.id) AS total_ventas,
    SUM(v.total) AS ingresos_totales,
    AVG(v.total) AS promedio_venta
FROM ventas v
GROUP BY YEAR(v.fecha_venta), MONTH(v.fecha_venta)
ORDER BY anio, mes;

