<?php
// Archivo: clases.php
include_once 'interfaces.php';

abstract class Tarea implements Detalle{
    public $id;
    public $titulo;
    public $descripcion;
    public $estado;
    public $prioridad;
    public $fechaCreacion;
    public $tipo;

    public function __construct($datos) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {  
                $this->$key = $value;
            }
        }
    }

    public function getEstado()
    {
        return $this->$estado;
    }
    public function getPrioridad($priori)
    {
        $this->$prioridad = $priori;
    }
    
    // public function obtenerDetallesEspecificos()
    // {
    //     #return $this->$tipoTest;
    // }
    // Implementar estos getters
    // public function getEstado() { }
    // public function getPrioridad() { }
}

class GestorTareas  {
    private $tareas = [];

    public function cargarTareas() {
        $json = file_get_contents('tareas.json');
        $data = json_decode($json, true);
        $objetoDesarrollo = [];
        $objetoDiseno = [];
        $objetoTesting = [];
        foreach ($data as $tareaData) {
            //echo "<br>" . $tareaData["tipo"];
            switch($tareaData['tipo'])
            {
                case 'desarrollo': $this->tareas[] = new TareaDesarrollo($tareaData); break;
                case 'diseno' : $this->tareas[] = new TareaDiseno($tareaData); break;
                case 'testing' : $this->tareas[] = new TareaTesting($tareaData);break;
            }
            #$tarea = new Tarea($tareaData);
            #$this->tareas[] = $tarea;
        }
        
        return $this->tareas;
    }
    public function agregarTarea($Tarea)
    {
        
    }
    public function eliminarTarea($id)
    {

    }
    public function actualizarEstadoTarea($id,$nuevoEstado)
    {

    }
    public function buscarTareasPorEstado($estado)
    {

    }
    public function listarTareas($filtroEstado = '')
    {

    }
}

class TareaDesarrollo extends Tarea
{
    public $lenguajeProgramacion = "";

    public function set_lenguaje ($lenguaje)
    {
        $this->$lenguajeProgramacion = $lenguaje;
    }
    public function get_lenguaje()
    {
        return $this->$lenguajeProgramacion;
    }

    public function obtenerDetallesEspecificos()
    {
        return $this->$lenguajeProgramacion;
    }
}

class TareaDiseno extends Tarea
{
    public $herramientaDiseno = "";

    public function set_herramienta ($herramientaDiseno)
    {
        $this->$herramientaDiseno = $herramienta;
    }
    public function get_herramienta()
    {
        return $this->$herramientaDiseno;
    }
    
    public function obtenerDetallesEspecificos()
    {
        return $this->$herramientaDiseno;
    }
}

class TareaTesting extends Tarea
{
    public $tipoTest = "";

    public function set_herramienta ($tipo)
    {
        $this->$tipoTest = $tipo;
    }

    public function get_herramienta()
    {
        return $this->$tipoTest;
    }
    
    public function obtenerDetallesEspecificos()
    {
        return $this->$tipoTest;
    }
}

// Implementar:
// 1. La interfaz Detalle
// 2. Modificar la clase Tarea para implementar la interfaz Detalle
// 3. Las clases TareaDesarrollo, TareaDiseno y TareaTesting que hereden de Tarea