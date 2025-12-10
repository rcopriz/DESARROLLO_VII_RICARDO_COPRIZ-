<?php
//creacion de actuvidades para un equipo

include_once '../manager/actividadesManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    //print_r($data);
    if (isset($data['id_equipo'], $data['tarea'],$data['intervalo_horas_maquina'], $data['fecha_ult_mant'], $data['cant_horas'],
     $data['horas_sig_mant'])) {
        $actividadesManager = new Actividades();
        $result = $actividadesManager->createActividad($data);
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Actividad creada exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al crear la actividad']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Faltan datos obligatorios']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}