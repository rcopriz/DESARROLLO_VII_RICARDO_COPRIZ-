
<?php
require_once "config_pdo.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $anio_publicacion = $_POST['anio_publicacion'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $autor = $_POST['autor'];
    $sql = "update libros 
            set titulo = :titulo,
            autor = :autor,
            isbn= :isbn,
            anio_publicacion = :anio_publicacion,
            cantidad_disponible = :cantidad_disponible
            where id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
        $stmt->bindParam(":autor", $autor, PDO::PARAM_STR);
        $stmt->bindParam(":isbn", $isbn, PDO::PARAM_STR);
        $stmt->bindParam(":anio_publicacion", $anio_publicacion, PDO::PARAM_STR);
        $stmt->bindParam(":cantidad_disponible", $cantidad_disponible, PDO::PARAM_STR);
        
        if($stmt->execute()){
            echo "<script>alert('Libro Actualizado Con Éxito')</script>";
        } else{
            $infoerror = $stmt->errorInfo()[2];
            echo "<script>alert('ERROR: No se pudo ejecutar $sql<br>$infoerror ')" ;
        }
    }
    
    unset($stmt);
    unset($pdo);
    //echo $_SERVER['HTTP_REFERER'];
    header('Location: ' . 'gestion_libros.php');
    exit;
}


if($_SERVER["REQUEST_METHOD"] == "GET"){
    
    $id = $_GET['id'];
    $titulo = $_GET['titulo'];
    $isbn = $_GET['isbn'];
    $anio_publicacion = $_GET['anio_publicacion'];
    $cantidad_disponible = $_GET['cantidad_disponible'];
    $autor = $_GET['autor'];
    #echo $id . " " . $titulo . " " . $isbn;
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilos.css">
        <title>CRUD de Libros</title>
        <style>
            /* Estilos básicos para mejor visualización */
            body { font-family: sans-serif; margin: 20px; }
            h2 { border-bottom: 2px solid #ccc; padding-bottom: 5px; }
            form div { margin-bottom: 15px; }
            label {  margin-bottom: 5px; font-weight: bold; }
            input[type="text"], input[type="number"] { width: 20%; padding: 8px; box-sizing: border-box; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            .acciones button { margin-right: 5px; padding: 5px 10px; cursor: pointer; }
        </style>
    </head>
    <body>

        <h1>Gestión de Libros (CRUD)</h1>

        <section id="formulario-libros">
            <h2>Editar Libro</h2>
            <form action="editar_libro.php" method="POST">
                
                <input type="hidden" id="id" name="id" value="<?php echo $id ?>">

                <div>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $titulo ?>" required>
                </div>

                <div>
                    <label for="autor">Autor:</label>
                    <input type="text" id="autor" name="autor" value="<?php echo $autor ?>" required>
                </div>

                <div>
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" maxlength="17" pattern="[0-9-]+" title="Solo números y guiones" value="<?php echo $isbn ?>" required>
                </div>

                <div>
                    <label for="anio_publicacion">Año de Publicación:</label>
                    <input type="number" id="anio_publicacion" name="anio_publicacion" min="1000" max="2099" value="<?php echo $anio_publicacion ?>" required>
                </div>

                <div>
                    <label for="cantidad_disponible">Cantidad Disponible:</label>
                    <input type="number" id="cantidad_disponible" name="cantidad_disponible" min="0" value="<?php echo $cantidad_disponible ?>" required>
                </div>

                <button type="submit">Guardar Libro</button>
            </form>
        </section>
    <?php
    }


?>
