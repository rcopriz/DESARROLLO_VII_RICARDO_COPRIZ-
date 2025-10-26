CREATE DATABASE taller8_db_rcopriz;
USE taller8_db_rcopriz;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nombre, email) VALUES
('Ana García', 'ana@example.com'),
('Carlos Rodríguez', 'carlos@example.com'),
('Elena Martínez', 'elena@example.com'),
('David López', 'david@example.com');


CREATE TABLE IF NOT EXISTS libros (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	titulo varchar(255) not null,
    autor varchar(255) not null,
    isbn varchar(255),
    anio_publicacion int,
    cantidad_disponible int
);
INSERT INTO libros (titulo, isbn, anio_publicacion, cantidad_disponible) VALUES
('Cien años de soledad', '978-84-376-0494-7', '1967', 12),
('El señor de los anillos', '978-84-450-7698-0', '1954', 8),
('Don Quijote de la Mancha', '978-84-376-0493-0', '1605', 5),
('1984', '978-84-376-1337-6', '1949', 10),
('Crimen y castigo', '978-84-376-1338-3', '1866', 7),
('La sombra del viento', '978-84-08-05525-7', '2001', 15),
('Harry Potter y la piedra filosofal', '978-84-9838-393-8', '1997', 20),
('Los juegos del hambre', '978-84-9918-276-9', '2008', 13),
('El código Da Vinci', '978-84-08-04932-4', '2003', 9),
('Fahrenheit 451', '978-84-376-1335-2', '1953', 6),
('El principito', '978-84-376-0490-9', '1943', 18),
('La casa de los espíritus', '978-84-204-0091-3', '1982', 10),
('Rayuela', '978-84-376-0491-6', '1963', 7),
('It', '978-84-9838-518-5', '1986', 11),
('Los pilares de la Tierra', '978-84-08-05615-5', '1989', 9),
('Orgullo y prejuicio', '978-84-376-1336-9', '1813', 14),
('El nombre del viento', '978-84-672-2361-9', '2007', 10),
('La historia interminable', '978-84-376-0492-3', '1979', 8),
('El alquimista', '978-84-376-1334-5', '1988', 16),
('Inferno', '978-84-08-12239-3', '2013', 12);

CREATE TABLE IF NOT EXISTS prestamos(
id INT auto_increment NOT NULL primary key,
id_usuario int not null references usuarios(id),
id_libro int not null references libros(id),
fecha_inicio date,
fecha_fin date,
libro_devuelto boolean
)