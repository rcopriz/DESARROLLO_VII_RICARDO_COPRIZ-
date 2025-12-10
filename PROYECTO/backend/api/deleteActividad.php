<?php
include_once '../manager/actividadesManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$data = json_decode(file_get_contents('php://input'), true);
    $data = $_POST;
    if (isset($data['id_actividad'])) {
        $actividadesManager = new Actividades();
        $result = $actividadesManager->deleteActividad($data['id_actividad']);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Actividad eliminada exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al eliminar la actividad']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'ID_ACTIVIDAD no proporcionado']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}