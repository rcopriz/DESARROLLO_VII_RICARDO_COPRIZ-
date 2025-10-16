<?php
//    function agregar_carrito($id,$descripcion,$precio)
//    {
       # print("entrando al carrito");
        
        session_start();
        echo "<br>";
       # print_r($_SESSION);
        echo "<br>";
       # print_r($_POST);
        echo "<br>";
        if(!isset($_SESSION['carrito']))
        {
            echo "<script>alert('Error Generando Carrito de Compras...')</script>";
            #$_SESSION['carrito'][]=['descripcion' => $_POST,'id' => $_POST['id'],'cantidad' => $_POST['cantidad']];
        }
        else
        {
            echo "si existe la sesion";
            $_SESSION['carrito'][]=['descripcion' => $_POST,'id' => $_POST['id'],'cantidad' => $_POST['cantidad']];
            echo "<br> " ;
            print_r($_SESSION['carrito']);
            
            /*
             echo "<ul>";

            foreach ($_SESSION['carrito'] as $prod => $key)
            {
                $descripcion = $key['descripcion'];
                $precio = $key['precio'];
                $id = $key['id'];
                echo "<br>";
                print("
                        <li>
                            <div class='descripcion'>$descripcion</div>
                            <div class='precio'>$precio</div>

                        </li>");
            }
            echo "</ul>";*/
        }
//    }


?>