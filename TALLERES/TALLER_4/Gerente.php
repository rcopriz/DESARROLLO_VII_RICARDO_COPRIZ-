<?php
include_once "Empleado.php";
include_once "Evaluable.php";

class Gerente extends Empleado implements Evaluable{
    private $departamento;
    function asignar_bonos($desarrollador, $bono)
    {
        return 0.3;
    }
    
    function evaluarDesempenio()
    {
        echo "<br> estamos evaluando el desempeño del gerente";
    }
}

?>