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
        $stmt = $this->pdo->prepare("INSERT INTO EQUIPO (NOMBRE, MODELO, ANO_FABRICACION, HORAS_MAQUINA) VALUES (:nombre, :modelo, :ano_fabricacion, :horas_maquina)");
        $stmt->bindParam(':nombre', $data['NOMBRE']);
        $stmt->bindParam(':modelo', $data['MODELO']);
        $stmt->bindParam(':ano_fabricacion', $data['ANO_FABRICACION'], PDO::PARAM_INT);
        $stmt->bindParam(':horas_maquina', $data['HORAS_MAQUINA'], PDO::PARAM_INT);
        return $stmt->execute();
    }
}