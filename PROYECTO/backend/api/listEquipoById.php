<?php

include_once '../manager/equiposManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id_equipo'])) {
        $equiposManager = new EquiposManager();
        $equipo = $equiposManager->getEquipoById($data['id_equipo']);

        if ($equipo) {
            http_response_code(200);
            echo json_encode($equipo);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Equipo no encontrado']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'ID_EQUIPO no proporcionado']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}