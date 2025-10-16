<?php 

include_once 'config_sesion.php';
#include_once 'agregar_al_carrito.php';
    #print($_SESSION['ultima_actividad']);
    if (!isset($_SESSION['ultima_actividad']))
    {
        print("ha ocurrido un error al generar la sesion");
    }
    $productos = [
         ['descripcion' => 'producto 1', 'precio' => 5.99 , 'id' => 1],
         ['descripcion' => 'producto 2', 'precio' => 3.99 , 'id' => 2],
         ['descripcion' => 'producto 3', 'precio' => 3.99 , 'id' => 3],
         ['descripcion' => 'producto 4', 'precio' => 3.99 , 'id' => 4],
         ['descripcion' => 'producto 5', 'precio' => 3.99 , 'id' => 5]
    ];

    function agregarProducto($productos,$producto, $precio)
    {
        $maxId = 0;
        foreach ($productos as $produc => $id){
            #print_r($produc);
            if($produc > $maxId)
            {
                $maxId=$produc;
            }
        }
        $maxId++;
        $productos[$maxId] =  [$producto,$precio];
        return $productos;
    }

    #$productos = agregarProducto($productos,"productoAgregado",1.99);
    
    #print_r($productos);
    echo "<ul>";
    foreach ($productos as $prod => $key)
    {
        $descripcion = $key['descripcion'];
        $precio = $key['precio'];
        $id = $key['id'];
        echo "<br>";
        print("
                <li>
                    <div class='descripcion'>$descripcion</div>
                    <div class='descripcion'>$precio</div>
                    <form action='agregar_al_carrito.php' >
                        <input id='descripcion' type='hidden' value='$descripcion'>
                        <input id='id' type='hidden' value='$id'>
                        <input id='precio' type='hidden' value='$precio'>
                        <button onclick='agregar_al_carrito.php'> agregar al carrito </button>
                    </form>
                </li>");
    }
    echo "</ul>";
    ?>
    
<a href="cerrar_sesion.php"> Cerrar Sesion </a>