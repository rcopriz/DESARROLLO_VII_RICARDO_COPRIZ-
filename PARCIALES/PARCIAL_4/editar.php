<?php
require_once 'database.php';
$database = new Database();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    
    
    $id = $_GET['id'];
    $nombre = $_GET['nombre'];
    $categoria = $_GET['categoria'];
    $precio = $_GET['precio'];
    $cantidad = $_GET['cantidad'];
    if (!isset($id)) {
        die("Faltan el ID del producto.");
    }
    ?>
    <h2>Editar Producto</h2>
    <form method="POST" action="editar.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br>
        <label>Categoría:</label><br>
        <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>" required><br>
        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required><br>
        <label>Cantidad:</label><br>
        <input type="number" name="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>" required><br><br>
        <input type="submit" value="Actualizar Producto">
    </form>
    
    <?php
}
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];

        $database->editarProducto($id, $nombre, $categoria, $precio, $cantidad);
        $database->closeCerrarConexion();
        header("Location: index.php");
    }

?>
<a href="crear.php">Agregar Producto</a>
<a href="index.php">Ver Productos</a>