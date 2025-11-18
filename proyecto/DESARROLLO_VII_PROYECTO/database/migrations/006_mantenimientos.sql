CREATE TABLE IF NOT EXISTS mantenimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    actividad INT,
    intervaloMantenimiento INT,
    CONSTRAINT fk_mantenimientos_actividad
        FOREIGN KEY (actividad) REFERENCES actividades(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);