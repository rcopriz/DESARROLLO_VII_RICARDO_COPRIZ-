<?php

class Equipo {
    private $pdo;

    public $id;
    public $descripcion;
    public $actividadMantenimiento;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("
            SELECT e.*, m.id AS mantenimiento_id, a.descripcion AS actividad
            FROM equipos e  
            LEFT JOIN mantenimientos m ON e.actividadMantenimiento = m.id
            LEFT JOIN actividades a ON m.actividad = a.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM equipos WHERE id = ?");  
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($descripcion, $actividadMantenimiento) {
        $stmt = $this->pdo->prepare("INSERT INTO equipos (descripcion, actividadMantenimiento) VALUES (?, ?)");
        $stmt->execute([$descripcion, $actividadMantenimiento]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $descripcion, $actividadMantenimiento) {
        $stmt = $this->pdo->prepare("UPDATE equipos SET descripcion = ?, actividadMantenimiento = ? WHERE id = ?");
        return $stmt->execute([$descripcion, $actividadMantenimiento, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM equipos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
