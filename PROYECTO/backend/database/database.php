<?php
include_once 'config_pdo.php';
    class Database {
    private $pdo = null;
    public function __construct() {
        try{
            $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("ERROR: No se pudo conectar. " . $e->getMessage());
        }
                $this->pdo = $pdo;  
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>