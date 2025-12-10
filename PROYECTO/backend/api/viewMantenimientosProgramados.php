<?php

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    include_once '../manager/actividadesManager.php';
    $actividadesManager = new Actividades();
    $mantenimientos = $actividadesManager->verMantenimientosProgramados();
    http_response_code(200);
   // print_r($mantenimientos);
    echo json_encode($mantenimientos);
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}