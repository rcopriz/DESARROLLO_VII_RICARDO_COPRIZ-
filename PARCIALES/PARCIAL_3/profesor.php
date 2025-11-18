<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index</title>
</head>
<body>
    <h1>Bienvenido</h1>
    <?php
    session_start();
    if (!isset($_SESSION["sesionUsuario"])) {
        header("Location: login.php");
        exit;
    }
    ?>
    <p>Has iniciado sesión correctamente.</p>
    <a href="profesor.php?action=cerrar">Cerrar sesión</a>
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
    if($_SERVER["REQUEST_METHOD"]==="GET")
    {
        if($_SESSION["rol"]!="profesor")
        {
            ?><script>alert("Acceso no autorizado. Por favor, inicie sesión como profesor.");</script>
            <?php
            header("Location: login.php");
            exit;
        }
      
        if(isset($_GET["action"]) && $_GET["action"]==="cerrar")
        {
            cerrarSesion();
        }
        foreach($array_notas as $estudiante => $notas)
        {
            echo "<h2>Notas de $estudiante:</h2>";
            echo "<ul>";
            foreach($notas as $nota)
            {
                echo "<li>$nota</li>";
            }
            echo "</ul>";
        }
    }

?>