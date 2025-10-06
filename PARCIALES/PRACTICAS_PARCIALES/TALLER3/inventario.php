<?php
 function leerProductos($nombreArchivo)
{
    return file_get_contents($nombreArchivo);
}

 function cadenaArreglo($cadena)
{
    return json_decode($cadena,true);
}

function ordenaArreglo($arreglo)
{
    return $arreglo[$i]['nombre'];
}

$productos = leerProductos("inventario.json");
$productos = cadenaArreglo($productos);
$productoa = usort($productos, 'ordenaArreglo');
print_r($productos);

?>