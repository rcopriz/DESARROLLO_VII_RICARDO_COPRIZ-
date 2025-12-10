<?php
include_once '../manager/equiposManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if (isset($data['descripcion'], $data['ubicacion'], $data['marca'], $data['modelo'], $data['ano_fabricacion'], $data['horas_maquina'])) {

        $equiposManager = new EquiposManager();
        $result = $equiposManager->createEquipo($data);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Equipo creado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al crear el equipo']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Datos incompletos para crear el equipo']);
    }
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Método no permitido']);
}
?>