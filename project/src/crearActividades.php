<?php
//endpoint para crear actividades
require_once '../config.php';
require_once '../modelos/database.php';
require_once '../modelos/actividad.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actividadManager = new Actividad();
    $actividadManager->create_actividad($_POST['descripcion']);
    header('Location: ' . BASE_URL);
    exit;
}

?>