<?php
    function contar_palabras_repetidas($texto)
    {
        $tmp_texto = trim($texto);
        $arreglo = explode(" ",$texto);
        $contador = 0;
        #var_dump($arreglo);
        $tmp_arreglo = [];
        foreach ($arreglo as $palabra) {
          #echo $palabra . "<br>";
            if ($palabra) {
              #  echo "Eres mayor de edad.";
            }
        }
        return $arreglo;
    }
    

    function capitalizar_palabras($texto)
    {
        $tmp_texto = strtolower($texto);
        $arreglo_texto = explode(" ", $tmp_texto);
        $tmp_cadena="";
        foreach ($arreglo_texto as $palab)
        {
            $tmp_cadena = $tmp_cadena . strtoupper(substr($palab, 0, 1)) . substr($palab, 1) . " ";
        }
        #print("<br><br>valor de tmp_cadena: $tmp_cadena");
        return $tmp_cadena;
    }

   
?>