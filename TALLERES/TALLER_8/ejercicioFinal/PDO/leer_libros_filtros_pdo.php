
<?php
require_once "config_pdo.php";

$sql = "SELECT id, titulo, autor, isbn, anio_publicacion, cantidad_disponible FROM libros WHERE titulo LIKE :filtro OR autor LIKE :filtro OR ISBN LIKE :filtro";

if($stmt = $pdo->prepare($sql)){
    if(isset($_POST['filtro']))
    {
        
        $stmt->bindParam(":filtro", $filtro, PDO::PARAM_STR);
        $filtro = $_POST['filtro'];
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
            
                while($row = $stmt->fetch()){
                    $id = $row['id'];
                    $titulo = $row['titulo'];
                    $autor =  $row['autor'];
                    $isbn = $row['isbn'];
                    $anio_publicacion = $row['anio_publicacion'];
                    $cantidad_disponible = $row['cantidad_disponible'];
                    $formulario = '<form action="" >
                        <input type="hidden" name="id" value="'.$id.'">
                        <input type="hidden" name="titulo" value="'.$titulo.'">
                        <input type="hidden" name="autor" value="'.$autor.'">
                        <input type="hidden" name="isbn" value="'.$isbn.'">
                        <input type="hidden" name="anio_publicacion" value="'.$anio_publicacion.'">
                        <input type="hidden" name="cantidad_disponible" value="'.$cantidad_disponible.'">

                        <button type="submit" name="accion" formmethod="GET"  formaction="editar_libro.php" value="editar"> ✏️ Editar</button>
                        <button type="submit" formmethod="POST" formaction="eliminar_libro.php" name="accion" value="eliminar" style="background-color: #f44336; color: white;">
                            🗑️ Eliminar </button>
                    </form>';
                    echo "<tr>";
                        echo "<td>" . $titulo . "</td>";
                        echo "<td>" . $autor . "</td>";
                        echo "<td>" . $isbn . "</td>";
                        echo "<td>" . $anio_publicacion . "</td>";
                        echo "<td>" . $row['cantidad_disponible'] . "</td>";
                        echo "<td> $formulario </td>"; 
                    echo "</tr>";
                }
            } else{
                echo "No se encontraron registros.";
            }
        } 
    }
    else{
        echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
    }
}

unset($stmt);
unset($pdo);
?>