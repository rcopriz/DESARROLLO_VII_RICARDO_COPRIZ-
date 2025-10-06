<?php
#funciones predefinidas php
echo strlen($texto); 
echo str_replace("str a buscar", "str reemplazo", $texto); 

//La función explode() divide una cadena en un array utilizando un delimitador especificado.
$partes = explode("caracter separador", $fecha);

//La función implode() une elementos de un array en una cadena.
$array = ["Hola", "mundo", "PHP"];
echo implode(" ", $array); // Salida: Hola mundo PHP

//La función count() cuenta el número de elementos en un array.
$frutas = ["manzana", "naranja", "plátano"];
echo count($frutas); // Salida: 3

//La función array_push() añade uno o más elementos al final de un array.
$colores = ["rojo", "verde"];
array_push($colores, "azul", "amarillo");
print_r($colores); // Array ( [0] => rojo [1] => verde [2] => azul [3] => amarillo )

//La función is_array() verifica si una variable es un array.
$var1 = [1, 2, 3];
echo is_array($var1) ? "Es un array" : "No es un array"; // Salida: Es un array

//La función date() formatea una fecha/hora local.
echo date("Y-m-d H:i:s"); // Salida: 2024-08-19 15:30:00

//La función file_get_contents() lee el contenido de un archivo en una cadena.
$contenido = file_get_contents("archivo.txt");
echo $contenido; // Salida: Hola Mundo

//La función json_encode() codifica un valor a formato JSON.
$array = ["nombre" => "Juan", "edad" => 30];
$json = json_encode($array);

//La función json_decode() decodifica una cadena JSON.
$json = '{"nombre":"Juan","edad":30}';
$objeto = json_decode($json); echo $objeto->nombre; 

//une dos arreglos
$array1 = ["a", "b"];
$array2 = ["c", "d"];
$resultado = array_merge($array1, $array2);

$texto = " Hola, mundo! "; //elimina los espacios en blanco al inicio y al final del string
echo trim($texto); // Salida: Hola, mundo!

//todo a minusculas
echo strtolower($texto);

//todo a mayusculas
echo strtoupper($texto); 

//sub cadena
echo substr($texto, 0, 4); // Salida: Hola "texto indice inicio

$frutas = ["manzana", "naranja", "plátano"];
echo in_array("naranja", $frutas) ? "Sí" : "No"; // Salida: Sí

$numeros = [1, 2, 3, 4, 5, 6];
$pares = array_filter($numeros, function($n) { return $n % 2 == 0; });

//La función array_map() aplica una función a cada elemento de un array.
$numeros = [1, 2, 3, 4, 5];
$cuadrados = array_map(function($n) { return $n * $n; }, $numeros);
print_r($cuadrados); // Array ( [0] => 1 [1] => 4 [2] => 9 [3] => 16 [4] => 25 )

//La función preg_match() realiza una comparación con expresiones regulares.
$texto = "El correo es ejemplo@correo.com";
$patron = "/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/";
echo preg_match($patron, $texto) ? "Coincide" : "No coincide"; // Salida: Coincide

//La función file_put_contents() escribe datos en un archivo.
$datos = "Hola, mundo!";
file_put_contents("nuevo_archivo.txt", $datos);

//lee el contenido de un archivo
$contenido = file_get_contents("nuevo_archivo.txt");
echo $contenido; // Salida: Hola, mundo!

//La función round() redondea un número de coma flotante con varias opciones de precisión y modo.
echo round(3.6); // Salida: 4 (redondeo estándar)
echo round(3.5, 0, PHP_ROUND_HALF_UP); // Salida: 4
echo round(3.5, 0, PHP_ROUND_HALF_DOWN); // Salida: 3
echo round(3.14159, 2); // Salida: 3.14 (2 decimales)
echo round(1234.5678, -2); // Salida: 1200 (redondeo a centenas)

//La función rand() genera un número entero aleatorio.
echo rand(1, 10); // Salida: Un número aleatorio entre 1 y 10

//La función array_sum() calcula la suma de los valores en un array.
$numeros = [1, 2, 3, 4, 5];
echo array_sum($numeros); // Salida: 15

$frutas = ["naranja", "manzana", "plátano"];
sort($frutas);
print_r($frutas); // Array ( [0] => manzana [1] => naranja [2] => plátano )

//La función strpos() encuentra la posición de la primera ocurrencia de una subcadena en una cadena.
$texto = "Hola, mundo!";
echo strpos($texto, "mundo"); // Salida: 6
?>

