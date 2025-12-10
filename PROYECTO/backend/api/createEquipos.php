<?php
include_once  '../manager/equiposManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['NOMBRE'], $data['MODELO'], $data['ANO_FABRICACION'], $data['HORAS_MAQUINA'])) {
        $equiposManager = new EquiposManager();
        $result = $equiposManager->createEquipo($data);

        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Equipo creado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al crear el equipo']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Datos incompletos para crear el equipo']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}