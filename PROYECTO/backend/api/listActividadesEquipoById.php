<?php
include_once '../manager/actividadesManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    //$input = $_GET;
    if (isset($input['id_equipo'])) {
        
        $equipoId = $input['id_equipo'];
        //print($equipoId);
        $actividadesManager = new Actividades();
        $actividades = $actividadesManager->getActividadesByEquipoId($equipoId);
        header('Content-Type: application/json');
        echo json_encode($actividades);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Falta el parámetro equipo_id']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}