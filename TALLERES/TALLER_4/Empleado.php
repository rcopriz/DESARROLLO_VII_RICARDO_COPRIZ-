<?php
class Empleado  {
    private $nombre;
    private $id_empleado;
    private $salario_base;

    public function __construct($nombre, $id_empleado,$salario_base)
    {
        $this->$nombre = $nombre;
        $this->$id_empleado = $id_empleado;
        $this->$salario_base;
    }
    function get_nombre()
    {
        return $this->$nombre;
    }
    
    function get_id_empleado()
    {
        return $this->$id_empleado;
    }

    function get_salario_base()
    {
        return $salario_base;
    }    

    public function set_nombre($tmp_nombre)
    {
        $this->$nombre=$tmp_nombre;
    }

    function set_id_empleado($tmp_id_empleado)
    {
        $this->$id_empleado=$tmp_id_empleado;
    }

    function set_salario_base($tmp_salario_base)
    {
        $this->$salario_base=$tmp_salario_base;
    }
}
?>