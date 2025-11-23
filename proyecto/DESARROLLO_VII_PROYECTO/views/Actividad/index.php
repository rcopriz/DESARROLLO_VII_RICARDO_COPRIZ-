<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');
// Include the configuration file
require_once BASE_PATH . '../../config.php';

//incluir los archivos necesarios de la base de datos y la gestion de maquinas
include '../../modelos/database.php';
include '../../modelos/actividad.php';
include '../../modelos/equipo.php';
include '../../modelos/usuario.php';    
include '../../modelos/rol.php';
include '../../modelos/mantenimiento.php'; 

// Get the action from the URL, default to 'list' if not set
$action = $_GET['action'] ?? 'list';

// Create an instance of Actividad
$actividadManager = new Actividad();
// Handle different actions
switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $actividadManager->create_actividad($_POST['descripcion']);
            header('Location: ' . BASE_URL);
            exit;
        }
        require BASE_PATH . 'views/task_form.php';
        break;
    case 'toggle':
        $actividadManager->find_actividad($_GET['id']);
        header('Location: ' . BASE_URL);
        break;
    case 'delete':
        $actividadManager->delete_actividad($_GET['id']);
        header('Location: ' . BASE_URL);
        break;
    default:
        $actividades = $actividadManager->all_actividad();
        require BASE_PATH . 'listaActividades.php';
        break;
}
?>