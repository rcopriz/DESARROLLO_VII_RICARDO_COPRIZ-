
<?php
require_once "config_pdo.php";

$sql = "SELECT id, nombre, email, fecha_registro FROM usuarios";

if($stmt = $pdo->prepare($sql)){
    try{
    $ejec = $stmt->execute();
    }
    catch (Throwable $e)
    {
        echo "ERROR: " . $e;
    }
    if($ejec){
        if($stmt->rowCount() > 0){
            require "../encabezado.php";
            while($row = $stmt->fetch()){
                echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['fecha_registro'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else{
            echo "No se encontraron registros.";
        }
    } else{
        echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
    }
}

unset($stmt);
unset($pdo);
?>