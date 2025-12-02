<?php
require_once 'config_pdo.php';
class Database {
    private $pdo;
    public function __construct() {
           try{
                //crear la conexión

                $this->pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
           catch(PDOException){
                // En caso de error, intenta crear la base de datos y la tabla
                //Crear la base de datos techparts_db y la tabla productos con las columnas: id (INT, PK, AI),
                //nombre (VARCHAR 120), categoria (VARCHAR 80), precio (DECIMAL 10,2), cantidad (INT),
                //fecha_registro (DATETIME DEFAULT NOW()).
                try{
                    echo "Creando base de datos y tabla";
                    $pdo = new PDO("mysql:host=" . DB_SERVER, DB_USERNAME, DB_PASSWORD);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
                    $pdo->exec("USE " . DB_NAME);
                    $crearTablaSql = "CREATE TABLE IF NOT EXISTS productos (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        nombre VARCHAR(120) NOT NULL,
                        categoria VARCHAR(80) NOT NULL,
                        precio DECIMAL(10,2) NOT NULL,
                        cantidad INT NOT NULL,
                        fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
                    )";
                    $pdo->exec($crearTablaSql);
                } 
                catch(PDOException $e){
                    die("ERROR: No se pudo crear la base de datos o la tabla. " . $e->getMessage());
                }
                
            }
    }
    //cerrar la conexión
    public function closeCerrarConexion() {
        $this->pdo = null;
    }
    //listar productos
    public function listarProductos() {
        $stmt = $this->pdo->prepare("SELECT id,nombre,categoria,precio,cantidad,fecha_registro FROM productos");
        $rows = $stmt->execute();
        ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
            echo "<td>" . htmlspecialchars($row['precio']) . "</td>";
            echo "<td>" . htmlspecialchars($row['cantidad']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fecha_registro']) . "</td>";
            ?>
            <td>
                <form method="post" action="eliminar.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <input type="submit" value="Eliminar">
                </form>
                <form method="get" action="editar.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                   <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>">
                   <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($row['categoria']); ?>">
                   <input type="hidden" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>">
                   <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($row['cantidad']); ?>">

                    <input type="submit" value="Editar">
                </form>
            </td>
            
            <?php
            echo "</tr>";
        }
        echo "</table>";
    }   
    //crear productos
    public function crearProducto($nombre, $categoria, $precio, $cantidad) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO productos (nombre, categoria, precio, cantidad) VALUES (:nombre, :categoria, :precio, :cantidad)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
            echo "<script>alert('Producto creado exitosamente');</script>";
         } catch (Exception $e) {
            echo "<script>alert('Error al crear el producto: " . $e->getMessage() . "');</script>";
            
         }
            
        }  

        // funcion para eliminar un producto mediante su ID
        public function eliminarProducto($id) {
            try {
                echo "Eliminando producto con ID: " . $id;
                $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                echo "<script>alert('Producto eliminado exitosamente');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Error al eliminar el producto: " . $e->getMessage() . "');</script>";
            }
   
    }
    //funcion para editar un producto mediante su ID
    public function editarProducto($id, $nombre, $categoria, $precio, $cantidad) {
        try {
            $stmt = $this->pdo->prepare("UPDATE productos SET nombre = :nombre, categoria = :categoria, precio = :precio, cantidad = :cantidad WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
            echo "<script>alert('Producto actualizado exitosamente');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error al actualizar el producto: " . $e->getMessage() . "');</script>";
        }
    }
}
    


?>