<?php
include_once 'config_sesion.php';
// Crear una cookie que expira en 1 hora
// setcookie("usuario", "Juan", time() + 3600, "/");
setcookie("usuario", "Juan",[
    'expires' => time() + 3600,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
echo "Cookie 'usuario' creada.";
?>
        