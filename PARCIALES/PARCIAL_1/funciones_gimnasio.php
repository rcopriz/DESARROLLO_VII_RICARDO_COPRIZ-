<?php
    function calcular_promocion($antiguedad_meses)
    {
        if($antiguedad_meses < 3)
        {
            return 0;
        }

        if($antiguedad_meses >= 3 && $antiguedad_meses <= 12)
        {
            return 0.08;
        }
        if($antiguedad_meses >= 13 && $antiguedad_meses <= 24)
        {
            return 0.12;
        }
        if($antiguedad_meses >= 24 )
        {
            return 0.2;
        }
    }

    function calcular_seguro_medico($cuota_base)
    {
        return $cuota_base * 0.05;
    }

    function calcular_cuota_final($cuota_base, $descuento_porcentaje, $seguro_medico)
    {
        return $cuota_base - ($cuota_base * ($descuento_porcentaje / 100)) + $seguro_medico;
    }

    /*
    print(calcular_promocion(1) . "<br>");
    print(calcular_promocion(5) . "<br>");
    print(calcular_promocion(13) . "<br>");
    print(calcular_promocion(25) . "<br>");
    */

?>