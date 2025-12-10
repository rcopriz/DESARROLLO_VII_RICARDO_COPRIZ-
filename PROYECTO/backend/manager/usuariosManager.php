<?php

include_once  '../database/database.php';
class UsuariosManager {
    private $pdo;

    public function __construct() {
        $pdo_tmp = new Database();
        $this->pdo = $pdo_tmp->getConnection();
        $pdo_tmp = null;
    }

    public function getAllUsuarios() {
        $stmt = $this->pdo->query("SELECT * FROM USUARIOS");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsuarioById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM USUARIOS WHERE ID_USUARIO = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createUsuario($data) {
        $stmt = $this->pdo->prepare("INSERT INTO USUARIOS (NOMBRE, USUARIO, CORREO, CLAVE_HASH, ROL, ESTADO) VALUES (:nombre, :usuario, :correo, :clave_hash, :rol, :estado)");
        $stmt->bindParam(':nombre', $data['NOMBRE']);
        $stmt->bindParam(':usuario', $data['USUARIO']);
        $stmt->bindParam(':correo', $data['CORREO']);
        $stmt->bindParam(':clave_hash', $data['CLAVE_HASH']);
        $stmt->bindParam(':rol', $data['ROL']);
        $stmt->bindParam(':estado', $data['ESTADO']);
        return $stmt->execute();
    }
    public function updateUsuario($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE USUARIOS SET NOMBRE = :nombre, USUARIO = :usuario, CORREO = :correo, CLAVE_HASH = :clave_hash, ROL = :rol, ESTADO = :estado WHERE ID_USUARIO = :id");
        $stmt->bindParam(':nombre', $data['NOMBRE']);
        $stmt->bindParam(':usuario', $data['USUARIO']);
        $stmt->bindParam(':correo', $data['CORREO']);
        $stmt->bindParam(':clave_hash', $data['CLAVE_HASH']);
        $stmt->bindParam(':rol', $data['ROL']);
        $stmt->bindParam(':estado', $data['ESTADO']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteUsuario($id) {
        $stmt = $this->pdo->prepare("DELETE FROM USUARIOS WHERE ID_USUARIO = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}