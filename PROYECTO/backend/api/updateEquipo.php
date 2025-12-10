<?php
include_once  '../manager/equiposManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if (isset($data['descripcion'], $data['ubicacion'], $data['marca'], $data['modelo'], $data['ano_fabricacion'], $data['horas_maquina'], $data['id_equipo'])) {
        $equiposManager = new EquiposManager();
        $res = $equiposManager->updateEquipo($data);

        if ($res) {
            http_response_code(200);
            echo json_encode(['message' => 'Equipo actualizado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al actualizar el equipo']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Datos incompletos para actualizar el equipo']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}