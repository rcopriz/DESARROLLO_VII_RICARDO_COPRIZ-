<?php

class Usuario {
    private $pdo;

    public $id;
    public $username;
    public $email;
    public $rol;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("
            SELECT u.*, r.descripcion AS rol_descripcion
            FROM usuarios u
            LEFT JOIN roles r ON u.rol = r.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $rol) {
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (username, email, rol) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $rol]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $username, $email, $rol) {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET username = ?, email = ?, rol = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $rol, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
