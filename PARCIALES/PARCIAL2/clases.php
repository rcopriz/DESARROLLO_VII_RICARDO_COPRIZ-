<?php
// Archivo: clases.php

interface Inventariable{
    public function obtenerInformacionInventario():string;
}

abstract class Producto implements Inventariable{
    public $id;
    public $nombre;
    public $descripcion;
    public $estado;
    public $stock;
    public $fechaIngreso;
    public $categoria;

    public function __construct($datos) {
        foreach ($datos as $clave => $valor) {
            if (property_exists($this, $clave)) {
                $this->$clave = $valor;
            }
        }
    }
}

class ProductoElectronico extends Producto{
    public $garantiaMeses;

    public function obtenerInformacionInventario(): string{
        return "Meses de garantia: " . $this-> garantiaMeses;
    }
}

class ProductoAlimento extends Producto {
    public $fechaVencimiento;
    public function obtenerInformacionInventario(): string{
        return "fecha de vencimiento: " . $this-> fechaVencimiento;
    }
}

class ProductoRopa extends Producto {
    public $talla;
        public function obtenerInformacionInventario(): string{
        return "talla : " . $this-> talla;
    }
}

class GestorInventario {
    private $items = [];
    private $rutaArchivo = 'productos.json';

    public function obtenerTodos() {
        if (empty($this->items)) {
            $this->cargarDesdeArchivo();
        }
        return $this->items;
    }
//---=
    private function cargarDesdeArchivo() {
        if (!file_exists($this->rutaArchivo)) {
            return;
        }
        
        $jsonContenido = file_get_contents($this->rutaArchivo);
        $arrayDatos = json_decode($jsonContenido, true);
        
        if ($arrayDatos === null) {
            return;
        }
        
        foreach ($arrayDatos as $datos) {
            //$this->items[] = new Producto($datos);
            $producto = null;
            if($datos['categoria']==="electronico"){
                $producto = new ProductoElectronico($datos);
                $this->items[] = $producto;
            } elseif($datos['categoria']==="alimento"){
                $producto = new ProductoAlimento($datos);
                $this->items[] = $producto;
            } elseif ($datos['categoria']==="ropa"){
                $producto = new ProductoRopa($datos);
                $this->items[] = $producto;
            }
        }
        return $this->items;
    }

    public function agregar($nuevoProducto){
        $this->cargarDesdeArchivo();
        if($nuevoProducto['categoria']==="electronico"){
                $producto = new ProductoElectronico($nuevoProducto);
            } elseif($nuevoProducto['categoria']==="alimento"){
                $producto = new ProductoAlimento($nuevoProducto);
            } elseif ($nuevoProducto['categoria']==="ropa"){
                $producto = new ProductoRopa($nuevoProducto);
            }
         $producto->id = $this->obtenerMaximoId()+1;
         $producto->fechaIngreso = date("Y-m-d");
         $this->items[] = $producto;
         $this->persistirEnArchivo();
     }

public function eliminar($idProducto){
        $this->cargarDesdeArchivo();
        $c = 0 ;
        $items = [];
        foreach ($this->items as $item) {
            print_r("valor de item id:$item->id\n valor de id a eliminar: $idProducto\n");
            if($item->id != $idProducto){
                print_r($idProducto);
                $items[] = $item;
                $c++;

            }
            
        }
        $this->items = $items;
        $this->persistirEnArchivo();
    }

    private function persistirEnArchivo() {
        $arrayParaGuardar = array_map(function($item) {
            return get_object_vars($item);
        }, $this->items);
        
        file_put_contents(
            $this->rutaArchivo, 
            json_encode($arrayParaGuardar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function obtenerMaximoId() {
        if (empty($this->items)) {
            return 0;
        }
        
        $ids = array_map(function($item) {
            return $item->id;
        }, $this->items);
        
        return max($ids);
    }
}