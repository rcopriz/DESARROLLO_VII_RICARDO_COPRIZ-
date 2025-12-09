<?php

class Actividades {
    private $pdo;

    public function __construct() {
        $pdo_tmp = new Database();
        $this->pdo = $pdo_tmp->getConnection();
        $pdo_tmp = null;
    }

    public function getActividadesByEquipoId($equipoId) {
        $stmt = $this->pdo->prepare("SELECT * FROM ACTIVIDAD_POR_EQUIPO WHERE ID_EQUIPO = :equipoId");
        $stmt->bindParam(':equipoId', $equipoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createActividad($data) {
        $stmt = $this->pdo->prepare("INSERT INTO ACTIVIDAD_POR_EQUIPO (ID_EQUIPO, DESCRIPCION, FECHA_ACTIVIDAD, DURACION_HORAS) VALUES (:id_equipo, :descripcion, :fecha_actividad, :duracion_horas)");
        $stmt->bindParam(':id_equipo', $data['ID_EQUIPO'], PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $data['DESCRIPCION']);
        $stmt->bindParam(':fecha_actividad', $data['FECHA_ACTIVIDAD']);
        $stmt->bindParam(':duracion_horas', $data['DURACION_HORAS'], PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteActividad($id) {
        $stmt = $this->pdo->prepare("DELETE FROM ACTIVIDAD_POR_EQUIPO WHERE ID_ACTIVIDAD = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function updateActividad($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE ACTIVIDAD_POR_EQUIPO SET DESCRIPCION = :descripcion, FECHA_ACTIVIDAD = :fecha_actividad, DURACION_HORAS = :duracion_horas WHERE ID_ACTIVIDAD = :id");
        $stmt->bindParam(':descripcion', $data['DESCRIPCION']);
        $stmt->bindParam(':fecha_actividad', $data['FECHA_ACTIVIDAD']);
        $stmt->bindParam(':duracion_horas', $data['DURACION_HORAS'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}