<?php
include_once '../manager/equiposManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $equiposManager = new EquiposManager();
    $equipos = $equiposManager->getAllEquipos();

    http_response_code(200);
    echo json_encode($equipos);
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}