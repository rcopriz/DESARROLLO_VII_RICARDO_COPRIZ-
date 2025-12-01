<?php 
require_once '../config.php';
require_once '../modelos/database.php';
require_once '../modelos/actividad.php';
// Iniciamos el buffer de salida
ob_start(); 

$actividadManager = new Actividad();
$actividades = $actividadManager->all_actividad();

// imprimir la lista de actividades como arreglo api


// Guardamos el contenido del buffer en la variable $content
$content = ob_get_clean();

?>