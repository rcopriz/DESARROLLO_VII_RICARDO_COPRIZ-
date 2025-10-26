<?php
    require_once "config_pdo.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    //$sql = "INSERT INTO usuarios (nombre, email) VALUES (:nomb, :correo)";
    $sql = "update usuarios
            set nombre = :nombre,
                email = :email
            where id = :id;";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        try{
            $ejecuta = $stmt->execute();
            if ($ejecuta) {
                echo "usuario actualizado con exito.";
            }
            else{
                echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
            }
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
    <div><label>ID</label><input type="text" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Actualizar Usuario">
</form> 