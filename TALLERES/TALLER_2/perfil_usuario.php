<?php
// Definición de variables
$nombre_completo = "Ricardo Copriz";
$edad = 29;
$correo = "ricardocopriz@gmail.com";
$telefono = "6300-6558";


// Definición de constante
define("OCUPACION", "Analista de Sistemas");

// Creación de mensaje usando diferentes métodos de concatenación e impresión
$mensaje1 = "Hola, mi nombre es " . $nombre_completo . " y tengo " . $edad . " años." . " Soy" . OCUPACION ;
$mensaje2 = "Mi Correo es $correo mi telefono es $telefono.";

echo $mensaje1 . "<br>";
print($mensaje2 . "<br>");
printf("Es decir: %s, %d años, %s, %s<br>", $nombre_completo, $edad, $correo, OCUPACION . "<br>");

echo "<br>Información de debugging:<br>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump(OCUPACION);
echo "<br>";
?>
                    