<?php
    require_once "config_pdo.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    
    //$sql = "INSERT INTO usuarios (nombre, email) VALUES (:nomb, :correo)";
    $sql = "delete from usuarios where id = :id";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        
        try{
            $stmt->execute();
            echo "usuario eliminado con exito.";
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
    <div><label>id</label><input type="text" name="id" required></div>
    <input type="submit" value="Eliminar Usuario">
</form> 