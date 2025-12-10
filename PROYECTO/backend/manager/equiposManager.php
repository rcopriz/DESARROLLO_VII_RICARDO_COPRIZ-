<?php
include_once __DIR__ . '/../database/database.php';
class EquiposManager {

    private $pdo;

    public function __construct() {
        $pdo_tmp = new Database();
        $this->pdo = $pdo_tmp->getConnection();
        $pdo_tmp = null;
    }

    public function getAllEquipos() {
        $stmt = $this->pdo->query("SELECT * FROM EQUIPO");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEquipoById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM EQUIPO WHERE ID_EQUIPO = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEquipo($data) {
        $stmt = $this->pdo->prepare("INSERT INTO EQUIPO (DESCRIPCION, UBICACION, MARCA, MODELO, ANO_FABRICACION, HORAS_MAQUINA) VALUES (:descripcion, :ubicacion, :marca, :modelo, :ano_fabricacion, :horas_maquina)");
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':ubicacion', $data['ubicacion']);
        $stmt->bindParam(':marca', $data['marca']);
        $stmt->bindParam(':modelo', $data['modelo']);
        $stmt->bindParam(':ano_fabricacion', $data['ano_fabricacion'], PDO::PARAM_INT);
        $stmt->bindParam(':horas_maquina', $data['horas_maquina'], PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function updateEquipo($data) {
        $stmt = $this->pdo->prepare("UPDATE EQUIPO SET DESCRIPCION = :descripcion, 
        UBICACION = :ubicacion, MARCA = :marca, MODELO = :modelo, ANO_FABRICACION = :ano_fabricacion, HORAS_MAQUINA = :horas_maquina WHERE ID_EQUIPO = :id");
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':ubicacion', $data['ubicacion']);
        $stmt->bindParam(':marca', $data['marca']);
        $stmt->bindParam(':modelo', $data['modelo']);
        $stmt->bindParam(':ano_fabricacion', $data['ano_fabricacion'], PDO::PARAM_INT);
        $stmt->bindParam(':horas_maquina', $data['horas_maquina'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $data['id_equipo'], PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteEquipo($id) {
        $stmt = $this->pdo->prepare("DELETE FROM EQUIPO WHERE ID_EQUIPO = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

