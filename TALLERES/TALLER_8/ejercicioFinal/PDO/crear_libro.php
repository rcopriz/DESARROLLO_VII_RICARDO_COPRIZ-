
<?php
require_once "config_pdo.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $anio_publicacion = $_POST['anio_publicacion'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $autor = $_POST['autor'];
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) VALUES (:titulo, :autor, :isbn, :anio_publicacion, :cantidad_disponible)";
    
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
        $stmt->bindParam(":autor", $autor, PDO::PARAM_STR);
        $stmt->bindParam(":isbn", $isbn, PDO::PARAM_STR);
        $stmt->bindParam(":anio_publicacion", $anio_publicacion, PDO::PARAM_STR);
        $stmt->bindParam(":cantidad_disponible", $cantidad_disponible, PDO::PARAM_STR);
        
        if($stmt->execute()){
            echo "<script>alert('Libro Creado Con Éxito')</script>";
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
