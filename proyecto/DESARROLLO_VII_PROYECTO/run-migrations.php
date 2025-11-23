<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/baseDatos/MigrationManager.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $migrationsPath = __DIR__ . '/baseDatos/migraciones';
    $migrationManager = new MigrationManager($pdo, $migrationsPath);
    $migrationManager->migrate();

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}