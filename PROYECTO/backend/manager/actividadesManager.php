<?php
include_once '../database/database.php';
class Actividades {
    private $pdo;
    public function __construct() {
        $pdo_tmp = new Database();
        $this->pdo = $pdo_tmp->getConnection();
        $pdo_tmp = null;
    }

    public function getActividadesByEquipoId($equipoId) {
        $stmt = $this->pdo->prepare("SELECT * FROM TAREAS_EQUIPO WHERE ID_EQUIPO = :equipoId");
        $stmt->bindParam(':equipoId', $equipoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createActividad($data) {
        $stmt = $this->pdo->prepare("INSERT INTO TAREAS_EQUIPO (ID_EQUIPO, TAREA, INTERVALO_HORAS_MAQUINA, 
        FECHA_ULT_MANT, CANT_HORAS, HORAS_SIG_MANTENIMIENTO, FECHA_SIG_MANTENIMIENTO, ULTIMO_TECNICO, SIG_TECNICO_ASIGN) 
        VALUES (:id_equipo, :tarea, :intervalo_horas_maquina, :fecha_ult_mant, :cant_horas, :horas_sig_mantenimiento, 
        :fecha_sig_mantenimiento, :ultimo_tecnico, :sig_tecnico_asign)");
        $stmt->bindParam(':id_equipo', $data['id_equipo'], PDO::PARAM_INT);
        $stmt->bindParam(':tarea', $data['tarea']);
        $stmt->bindParam(':intervalo_horas_maquina', $data['intervalo_horas_maquina'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_ult_mant', $data['fecha_ult_mant']);
        $stmt->bindParam(':cant_horas', $data['cant_horas'], PDO::PARAM_INT);
        $stmt->bindParam(':horas_sig_mantenimiento', $data['horas_sig_mantenimiento'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_sig_mantenimiento', $data['fecha_sig_mantenimiento']);
        $stmt->bindParam(':ultimo_tecnico', $data['ultimo_tecnico']);
        $stmt->bindParam(':sig_tecnico_asign', $data['sig_tecnico_asign']);
        return $stmt->execute();
    }

    public function deleteActividad($id) {
        $stmt = $this->pdo->prepare("DELETE FROM TAREAS_EQUIPO WHERE ID_TAREA = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateActividad($data) {
       
        $stmt = $this->pdo->prepare("UPDATE TAREAS_EQUIPO SET TAREA = :tarea, 
        INTERVALO_HORAS_MAQUINA = :intervalo_horas_maquina, FECHA_ULT_MANT = :fecha_ult_mant, 
        CANT_HORAS = :cant_horas, 
        HORAS_SIG_MANTENIMIENTO = :horas_sig_mantenimiento, 
        FECHA_SIG_MANTENIMIENTO = :fecha_sig_mantenimiento, 
        ULTIMO_TECNICO = :ultimo_tecnico, SIG_TECNICO_ASIGN = :sig_tecnico_asign WHERE ID_TAREA = :id");
        $stmt->bindParam(':tarea', $data['tarea']);
        $stmt->bindParam(':intervalo_horas_maquina', $data['intervalo_horas_maquina'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_ult_mant', $data['fecha_ult_mant']);
        $stmt->bindParam(':cant_horas', $data['cant_horas'], PDO::PARAM_INT);
        $stmt->bindParam(':horas_sig_mantenimiento', $data['horas_sig_mant'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_sig_mantenimiento', $data['fecha_sig_mant']);
        $stmt->bindParam(':ultimo_tecnico', $data['ult_tecnico_asig']);
        $stmt->bindParam(':sig_tecnico_asign', $data['sig_tecnico_asign']);
        $stmt->bindParam(':id', $data['id_tarea'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    public function getActividadById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM TAREAS_EQUIPO WHERE ID_TAREA = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllActividades() {
        $stmt = $this->pdo->prepare("SELECT * FROM TAREAS_EQUIPO");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function verMantenimientosProgramados() {
    $stmt = $this->pdo->query("SELECT * FROM V_TAREAS_MANTENIMIENTO");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    }
}