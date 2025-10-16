<?php
//    function agregar_carrito($id,$descripcion,$precio)
//    {
        print("entrando al carrito");
        if(!isset($_COOKIE['carrito']))
        {
            setcookie("carrito","carro",[
                                    'expires' => time() + 3600*24,
                                    'path' => '/',
                                    'domain' => '',
                                    'secure' => true,
                                    'httponly' => true,
                                    'samesite' => 'Strict'
            ]);

        }
        else
        {
            echo "si existe la cookie";
        }
//    }


?>