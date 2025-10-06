<?php
include_once "Empleado.php";
class Desarrollador extends Empleado{
    private $lenguajes=[];
    private $nivel=[];
    private $programador=[];

    function get_programador()
    {
        return '';
    }
    
    function get_lenguajes()
    {
        return '';
    }
    public function evaluarDesempenio()
    {
        echo "<br> estamos evaluando el desempeño del Desarrollador";
    }
}
?>