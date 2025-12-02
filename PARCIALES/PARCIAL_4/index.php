<a href="crear.php">Agregar Producto</a>
<a href="index.php">Ver Productos</a>
<?php
//La empresa TechParts requiere un módulo de gestión de productos utilizando PHP y MySQL.El estudiante debe implementar funcionalidades para registrar, listar, editar y eliminar productos.
//index.php debe mostrar tabla con todos los productos y enlaces para Editar y Eliminar.
require_once 'database.php';
$database = new Database($pdo);


$database->listarProductos();
$database->closeCerrarConexion();

?>