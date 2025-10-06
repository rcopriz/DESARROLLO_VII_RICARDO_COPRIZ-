<?php
    //print("hola");
    $str_inventario = file_get_contents("inventario.json");
    $array_inventario = json_decode($str_inventario);
    $array_ordenado = [];
    print("$str_inventario <br>");
    print_r($array_inventario);
    
    /*
    usort($array_inventario,function ($a,$b)
    {
        return $b["nombre"] <=> $a["nombre"];
    }
);

print("<br>despues ordenamiento<br>");
print_r($array_inventario);
*/

    #echo $str_inventario
    //print_r($array_inventario);
    $i = 0;
    foreach($array_inventario as $item)
    {
        #print_r($array_inventario[$i]);
        $nombre_item = $item->{'nombre'};
        $precio = $item->{'precio'};
        $cantidad = $item->{'cantidad'};
        $tmp ="";
        //$array_ordenado [] = json_decode("$nombre_item" -> {"precio : $precio "});
        //$array_ordenado[] = json_decode("{$nombre_item : {precio:$precio, cantidad:$cantidad}}");
        //$array_ordenado [] = ["$nombre_item" =>["cantidad" => $cantidad, "precio" => $precio]];
        echo "<br>";

        $i++;
    }
    print_r($array_ordenado);

        
?>