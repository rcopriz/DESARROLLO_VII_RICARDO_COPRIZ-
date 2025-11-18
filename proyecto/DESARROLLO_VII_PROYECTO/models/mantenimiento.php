<?php

class Mantenimiento {
    private $pdo;

    public $id;
    public $actividad;
    public $intervaloMantenimiento;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("
            SELECT m.*, a.descripcion AS actividad_descripcion
            FROM mantenimientos m
            LEFT JOIN actividades a ON m.actividad = a.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM mantenimientos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($actividad, $intervaloMantenimiento) {
        $stmt = $this->pdo->prepare("INSERT INTO mantenimientos (actividad, intervaloMantenimiento) VALUES (?, ?)");
        $stmt->execute([$actividad, $intervaloMantenimiento]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $actividad, $intervaloMantenimiento) {
        $stmt = $this->pdo->prepare("UPDATE mantenimientos SET actividad = ?, intervaloMantenimiento = ? WHERE id = ?");
        return $stmt->execute([$actividad, $intervaloMantenimiento, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM mantenimientos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
