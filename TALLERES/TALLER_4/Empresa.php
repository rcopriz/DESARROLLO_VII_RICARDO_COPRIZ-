<?php
include_once "Desarrollador.php";
include_once "Gerente.php";
include_once "Evaluable.php";

class Empresa 
{
    #private $id;
    #private $nombre;
    #private $salario;
    #private $departamento;

    public function __construct($id,$nombre,$salario,$departamento)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->salario = $salario;
        $this->departamento = $departamento;
    }
    public function agregarGerente()
    {
        $nuevo_gerente = new Gerente();
        print_r($nuevo_gerente);
        #print("<br>Estamos agregando a un gerente");
        return "<br>hola soy un gerente";
    }

    function agregarDesarrollador()
    {
        print("<br>estamos agregando a un desarrollador");
    }
}

$empresa = new Empresa(1,"Ricardo",3500.00,"TI");
print_r($empresa->agregarGerente());

?>