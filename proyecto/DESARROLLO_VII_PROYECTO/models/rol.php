<?php

class Role {
    private $pdo;

    public $id;
    public $descripcion;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM roles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($descripcion) {
        $stmt = $this->pdo->prepare("INSERT INTO roles (descripcion) VALUES (?)");
        $stmt->execute([$descripcion]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $descripcion) {
        $stmt = $this->pdo->prepare("UPDATE roles SET descripcion = ? WHERE id = ?");
        return $stmt->execute([$descripcion, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM roles WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
