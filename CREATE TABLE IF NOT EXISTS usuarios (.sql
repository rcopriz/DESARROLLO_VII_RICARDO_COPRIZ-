CREATE TABLE IF NOT EXISTS usuarios (
Id BINARY(16) PRIMARY KEY,
Nombre VARCHAR(50) NOT NULL,
Descripcion VARCHAR(50),
Precio FLOAT NOT NULL,
Estado BOOLEAN NOT NULL,
UsuarioCreacion VARCHAR(50),
FechaCreacion DATETIME,
UsuarioModificacion VARCHAR(50),
FechaModificacion DATETIME
)