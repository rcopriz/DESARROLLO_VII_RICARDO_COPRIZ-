<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
    include_once "datos.php";
    include_once "validaciones.php";
    session_start();
   
    if($_SERVER["REQUEST_METHOD"]==="POST")
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(validaLogintudUsuario($username) && validaLogintudPassword($password))
        {
            $index = array_search($username, $array_usuarios);
            if($index !== false && $array_passwords[$index] === $password)
            {
                $_SESSION["sesionUsuario"] = $username;
                $_SESSION["rol"] = $array_rol[$index];
                setcookie("rol", $array_rol[$index], time() + 3600);
                if($_SESSION["rol"] === "profesor")
                {
                    header("Location: profesor.php");
                    exit;
                }
                elseif($_SESSION["rol"] === "estudiante")
                {
                    header("Location: estudiante.php");
                    exit;
                }
            }
            else
            {
                echo "<script>alert('Credenciales inválidas.');</script>";
            }
        }
        else
        {
            echo "<script>alert('El nombre de usuario debe tener al menos 3 caracteres y la contraseña al menos 5 caracteres.');</script>";
        }
    }
?>