<?php

class Actividad {
    private $pdo;

    public $id;
    public $descripcion;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function all_actividad() {
        $stmt = $this->pdo->query("SELECT * FROM actividades");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find_actividad($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM actividades WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create_actividad($descripcion) {
        $stmt = $this->pdo->prepare("INSERT INTO actividades (descripcion) VALUES (?)");
        $stmt->execute([$descripcion]);
        return $this->pdo->lastInsertId();
    }

    public function update_actividad($id, $descripcion) {
        $stmt = $this->pdo->prepare("UPDATE actividades SET descripcion = ? WHERE id = ?");
        return $stmt->execute([$descripcion, $id]);
    }

    public function delete_actividad($id) {
        $stmt = $this->pdo->prepare("DELETE FROM actividades WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
