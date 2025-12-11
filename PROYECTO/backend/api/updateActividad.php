<?php
include_once '../manager/actividadesManager.php';
//actualizar una actividad por id
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    //print_r($data);
    $id_tarea = $data['id_tarea'];
    $id_equipo = $data['id_equipo'];
    $tarea = $data['tarea'];
    $intervalo_horas_maquina = $data['intervalo_horas_maquina'];
    $fecha_ult_mant = $data['fecha_ult_mant'];
    $cant_horas = $data['cant_horas'];
    $horas_sig_mantenimiento = $data['horas_sig_mant'];
    $ultimo_tecnico = $data['ult_tecnico_asig'];
    $fecha_sig_mantenimiento = $data['fecha_sig_mant'];
    $siguiente_tecnico = $data['sig_tecnico_asig'];

    if (isset($id_tarea, $id_equipo, $tarea, $intervalo_horas_maquina, $fecha_ult_mant, $cant_horas, $horas_sig_mantenimiento, $fecha_sig_mantenimiento)) {
        $actividadesManager = new Actividades();
        $result = $actividadesManager->updateActividad($data);
        
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