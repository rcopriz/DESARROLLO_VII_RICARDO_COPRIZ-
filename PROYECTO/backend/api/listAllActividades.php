<?php
include_once '../manager/actividadesManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $manager = new Actividades();
    $actividades = $manager->getAllActividades();
    header('Content-Type: application/json');
    echo json_encode($actividades);
}