CREATE TABLE IF NOT EXISTS equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255),
    actividadMantenimiento INT,
    CONSTRAINT fk_equipos_mantenimiento
        FOREIGN KEY (actividadMantenimiento) REFERENCES mantenimientos(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);