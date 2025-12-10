<?php
include_once '../manager/actividadesManager.php';
//actualizar una actividad por id
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if (isset($data['id_actividad'], $data['tarea'], $data['intervalo_horas_maquina'], $data['fecha_ult_mant'], $data['cant_horas'], $data['horas_sig_mantenimiento'], $data['fecha_sig_mantenimiento'], $data['ultimo_tecnico'], $data['sig_tecnico_asign'])) {
        $actividadesManager = new Actividades();
        $result = $actividadesManager->updateActividad($data['id_actividad'], $data);
        
        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Actividad actualizada exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al actualizar la actividad']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Datos incompletos para actualizar la actividad']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}