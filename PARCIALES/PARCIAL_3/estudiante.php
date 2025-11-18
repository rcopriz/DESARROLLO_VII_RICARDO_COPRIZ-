<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estudiante</title>   
</head>
<body>
    <a href="login.php?action=cerrar">Cerrar sesión</a>
</body>
</html> 
<?php
    include_once "datos.php";
    function cerrarSesion() {    
        setcookie("rol", "", time() - 3600);   
        session_start();
        session_destroy();
        header("Location: login.php");
        exit;
    }
    session_start();
    if (!isset($_SESSION["sesionUsuario"])) {
        header("Location: login.php");
        exit;
    }
    echo "<h1>Bienvenido, " . $_SESSION["sesionUsuario"] . "</h1>";
    if($_SERVER["REQUEST_METHOD"]==="GET")
    {
        
        if($_SESSION["rol"]!="estudiante")
        {   
            ?><script>alert("Acceso no autorizado. Solo los estudiantes pueden acceder a esta página.");</script>
            <?php
            header("Location: login.php");
            exit;
        }
        if(isset($_GET["action"]) && $_GET["action"]==="cerrar")
        {
            cerrarSesion();
        }
        echo "<h2>Notas de " . $_SESSION["sesionUsuario"] . ":</h2>";
        echo "<ul>";
        foreach($array_notas[$_SESSION["sesionUsuario"]] as $notas)
        {
         
                echo "<ul>";
                    echo "<li>$notas</li>";
                
                echo "</ul>";
            
        }
    }
?>