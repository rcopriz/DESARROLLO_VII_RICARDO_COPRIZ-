<?php
//vista para listar actividades que vienen como array asociativo desde la base de datos
require_once '../config.php';
require_once '../modelos/database.php';
require_once '../modelos/actividad.php';
require_once '../src/listaActividades.php';
// Iniciamos el buffer de salida
ob_start();
$actividadManager = new Actividad();
$actividades = $actividadManager->all_actividad();

// imprimir la lista de actividades
foreach ($actividades as $actividad) {
    #tabla de actividades
    echo "<tr>";
    echo "<td>" . htmlspecialchars($actividad['id']) . "</td>";
    echo "<td>" . htmlspecialchars($actividad['descripcion']) . "</td>";
    echo "</tr>";
}
// Guardamos el contenido del buffer en la variable $content
$content = ob_get_clean();
    require_once 'layout.php';
?>