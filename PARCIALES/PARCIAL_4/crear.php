<?php
//crear productos
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'database.php';
    $database = new Database();

    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $database->crearProducto($nombre, $categoria, $precio, $cantidad);
    $database->closeCerrarConexion();
    header("Location: crear.php");
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    ?>
    <h2>Crear Producto</h2>
    <form method="post" action="crear.php">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br>
        <label>Categoría:</label><br>
        <input type="text" name="categoria" required><br>
        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" required><br>
        <label>Cantidad:</label><br>
        <input type="number" name="cantidad" required><br><br>
        <input type="submit" value="Crear Producto">
    </form>
    <a href="crear.php">Agregar Producto</a>
<a href="index.php">Ver Productos</a>
<a href="editar.php">Editar Producto</a>
    <?php
}
?>
<a href="crear.php">Agregar Producto</a>
<a href="index.php">Ver Productos</a>