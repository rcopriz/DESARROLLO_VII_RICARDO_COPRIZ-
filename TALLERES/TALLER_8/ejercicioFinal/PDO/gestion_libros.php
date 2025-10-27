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
        <h2>Añadir/Editar Libro</h2>
        <form action="crear_libro.php" method="POST">
            
            <input type="hidden" id="id" name="id" value="">

            <div>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div>
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" required>
            </div>

            <div>
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" maxlength="17" pattern="[0-9-]+" title="Solo números y guiones" required>
            </div>

            <div>
                <label for="anio_publicacion">Año de Publicación:</label>
                <input type="number" id="anio_publicacion" name="anio_publicacion" min="1000" max="2099" required>
            </div>

            <div>
                <label for="cantidad_disponible">Cantidad Disponible:</label>
                <input type="number" id="cantidad_disponible" name="cantidad_disponible" min="0" required>
            </div>

            <button type="submit">Guardar Libro</button>
            <button type="reset">Limpiar Formulario</button>
        </form>
    </section>

    <hr>
<section id="busqueda-simple">
    <h2>Búsqueda de Libros</h2>
    
    <form action="gestion_libros.php" method="POST"> 
        
        <input 
            type="text" id="filtro" name="filtro" placeholder="Buscar por título, autor o ISBN..." size="50"
            value="<?php echo htmlspecialchars($_GET['filtro'] ?? ''); ?>">
        <button type="submit">Buscar 🔎</button>
        <button type="submit" formmethod="GET">Listar Todos 📋</button>
    </form>
</section>
<hr>
    <section id="lista-libros">
        <h2>Catálogo de Libros</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Año Publicación</th>
                    <th>Cantidad Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                require "leer_libros_filtros_pdo.php";
            }
            else
            {
                require "leer_libros_pdo.php";
            }
            ?>
            </tbody>
        </table>
    </section>

    <script>
        function editarLibro(id) {
            alert('Simulación: Cargar datos del libro ID ' + id + ' en el formulario para editar.');
            // En una aplicación real, harías una petición AJAX para obtener los datos.
        }

        function eliminarLibro(id) {
            if (confirm('¿Estás seguro de que quieres eliminar el libro ID ' + id + '?')) {
                alert('Simulación: Enviando solicitud de eliminación para el libro ID ' + id);
                // En una aplicación real, enviarías una petición DELETE o POST al servidor.
            }
        }
    </script>

</body>
</html>