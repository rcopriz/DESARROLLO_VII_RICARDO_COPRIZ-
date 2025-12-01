<?php
include_once 'models/equipo.php';
include_once 'models/database.php';
class EquipoManager{
    private $db;
   
    public function __construct(){
        $this->db = Database::connect();
    }

    public function getAll(){
        $equipo = new Equipo($this->db);
        return $equipo->getAll();
    }
    public function findById($id){
        $equipo = new Equipo($this->db);
        return $equipo->findById($id);
    }   
    public function createEquipo($descripcion, $actividadMantenimiento){
        $equipo = new Equipo($this->db);
        return $equipo->createEquipo($descripcion, $actividadMantenimiento);
    }
    public function updateEquipo($id, $descripcion, $actividadMantenimiento){
        $equipo = new Equipo($this->db);
        return $equipo->updateEquipo($id, $descripcion, $actividadMantenimiento);
    }
    public function deleteEquipo($id){
        $equipo = new Equipo($this->db);
        return $equipo->deleteEquipo($id);
    }
}

?>