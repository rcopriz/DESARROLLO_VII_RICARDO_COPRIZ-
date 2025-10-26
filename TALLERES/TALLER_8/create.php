<?php
    require_once "config_pdo.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre_usuario = $_POST['nombre'];
    $correo_usuario = $_POST['email'];
    
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nomb, :correo)";
    
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":nomb", $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(":correo", $correo_usuario, PDO::PARAM_STR);
        
       /* if($stmt->execute()){
            echo "Usuario creado con éxito.";
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
        }*/
        try{
            $stmt->execute();
            echo "usuario creado con exito.";
        }
        catch(Throwable $e)
        {
            echo "error: " . $e;
        }
    }
    
    unset($stmt);
}

unset($pdo);

?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form> 