<?php 

include_once 'config_sesion.php';
#include_once 'agregar_al_carrito.php';
    #print($_SESSION['ultima_actividad']);
    if (!isset($_SESSION['ultima_actividad']))
    {
        echo "<script>alert('Ha Ocurrido un Error al Generar la Sesion')</script>";
        die();
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
    
        print_r($_SESSION);
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
                    <form action='agregar_al_carrito.php' method='post'>
                        <input name='descripcion' type='hidden' value='$descripcion'/>
                        <input name='id' type='hidden' value='$id'/>
                        <input name='precio' type='hidden' value='$precio'/>
                        <input name='cantidad' type='number'/>
                        <button onclick='agregar_al_carrito.php'> agregar al carrito </button>
                    </form>
                </li>");
    }
    echo "</ul>";
    ?>
    
<a href="cerrar_sesion.php"> Cerrar Sesion </a>