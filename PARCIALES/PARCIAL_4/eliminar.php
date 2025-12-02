<?php
require_once 'database.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(!isset($_POST['id'])){
    die("ID de producto no proporcionado.");
}   
    $id = $_POST['id'];

    $database = new Database();
    $database->eliminarProducto($id);
    $database->closeCerrarConexion();

    header("Location: index.php");
    exit();
}