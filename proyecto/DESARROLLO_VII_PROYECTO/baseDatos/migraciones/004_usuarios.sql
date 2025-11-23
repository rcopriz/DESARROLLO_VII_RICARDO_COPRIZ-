CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64) UNIQUE,
    email VARCHAR(255),
    rol INT,
    CONSTRAINT fk_usuarios_roles
        FOREIGN KEY (rol) REFERENCES roles(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);