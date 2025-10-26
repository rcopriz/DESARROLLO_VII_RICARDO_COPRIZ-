
<?php
require_once "config_pdo.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    $sql = "delete from libros where id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        
        if($stmt->execute()){
            echo "<script>alert('Libro Eliminado Con Éxito')</script>";
        } else{
            $infoerror = $stmt->errorInfo()[2];
            echo "<script>alert('ERROR: No se pudo ejecutar $sql<br>$infoerror ')" ;
        }
    }
    
    unset($stmt);
}

unset($pdo);

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
