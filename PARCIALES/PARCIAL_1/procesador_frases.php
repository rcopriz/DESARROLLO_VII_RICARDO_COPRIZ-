<table>

<?php
    include "operaciones_cadenas.php";

    $frases = ["los ganadores, ganan", "los perdedores, piedren", "uno uno dos tres", "vivan las frases"];
    foreach ($frases as $frase)
    {
?> <tr> <td><?php
        print($frase)
?> </td> <td> <?php
        $arreglo = contar_palabras_repetidas($frase);
        var_dump($arreglo);
    
?></td> <td> <?php
        $cadena = capitalizar_palabras($frase);
        var_dump($cadena);
        
?> <br> <?php
    }
?>

</table>