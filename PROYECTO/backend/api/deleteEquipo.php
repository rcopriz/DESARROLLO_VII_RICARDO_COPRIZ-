<?php
include_once '../manager/equiposManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['ID_EQUIPO'])) {
        $equiposManager = new EquiposManager();
        $result = $equiposManager->deleteEquipo($data['ID_EQUIPO']);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Equipo eliminado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al eliminar el equipo']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'ID_EQUIPO no proporcionado']);
    }
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Método no permitido']);
}