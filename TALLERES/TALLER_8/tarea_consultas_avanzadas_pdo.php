<?php
require_once "config_pdo.php";

try {
    // 1. ultimas 5 publicaciones 
    $sql = "SELECT u.nombre, p.fecha_publicacion as fecha 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id
            ORDER BY fecha DESC
            LIMIT 5";

    $stmt = $pdo->query($sql);

    echo "<h3>Autor y Fecha de Publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Autor: " . $row['nombre'] . ", Fecha: " . $row['fecha'] . "<br>";
    }

    // 2. Listar Usuarios sin publicaciones
    $sql = "SELECT DISTINCT u.nombre as autor
            FROM publicaciones p 
            RIGHT OUTER JOIN usuarios u ON p.usuario_id = u.id 
            ";

    $stmt = $pdo->query($sql);

    echo "<h3>Autores Sin Publicación:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo  "Autor: " . $row['autor'] . "<br>";
    }


    // 3. Encontrar promedio de publicaciones por usuario
    $sql = "SELECT count(p.id) / count(u.id) as promedio, count(p.id) as publicaciones , count(u.id) as usuarios
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            ORDER BY promedio DESC ";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Promedio: " . $row['promedio']. ", Número de publicaciones: " . $row['publicaciones'] . ", Número de usuarios: " . $row['usuarios'];


    // 4. Encontrar ultima publicacion de cada usuario
    $sql = "SELECT u.nombre, p.fecha_publicacion
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id 
            ORDER BY fecha_publicacion DESC 
            ";

    echo "<h3>Ultimas Publicaciones por Usuario:</h3>";
    $stmt = $pdo->query($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        echo "Nombre: " . $row['nombre'] . ", Fecha de publicaciones: " . $row['fecha_publicacion']."<br>";
    }


} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>