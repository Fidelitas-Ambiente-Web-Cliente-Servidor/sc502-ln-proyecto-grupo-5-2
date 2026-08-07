<?php
require_once './controllers/PlanNutricionalController.php';
require_once './controllers/PlanComidaController.php';
require_once './controllers/ExpedienteController.php';
require_once './controllers/RutinaController.php';

$page = $_GET['page'] ?? 'GestionarPlanes';

// GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (($_GET['option'] ?? '') === 'listarPlanes') {
        $controller = new PlanNutricionalController();
        $controller->listar();
        exit;
    }

    if (($_GET['option'] ?? '') === 'listarComidas') {
        $controller = new PlanComidaController();
        $controller->listar();
        exit;
    }
}

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (($_POST['option'] ?? '') === 'crearPlan') {
        $controller = new PlanNutricionalController();
        $controller->crear();
        exit;
    }

    if (($_POST['option'] ?? '') === 'eliminarPlan') {
        $controller = new PlanNutricionalController();
        $controller->eliminar();
        exit;
    }

    if (($_POST['option'] ?? '') === 'crearComida') {
        $controller = new PlanComidaController();
        $controller->crear();
        exit;
    }

    if (($_POST['option'] ?? '') === 'eliminarComida') {
        $controller = new PlanComidaController();
        $controller->eliminar();
        exit;
    }
}

// Carga las vistas
switch ($page) {
    case 'GestionarPlanes':
        $controller = new PlanNutricionalController();
        $controller->index();
        break;

    case 'GestionPacientes':
        $controller = new ExpedienteController();
        $controller->index();
        break;
        
    case 'GestionarRutinas':
        $controller = new RutinaController();
        $controller->index();
        break;

    case 'rutinas':
        require_once __DIR__ . '/views/rutinas.php';
        break;

    default:
        $controller = new PlanNutricionalController();
        $controller->index();
        break;

    case 'PlanNutricional':
        require_once __DIR__ . '/views/PlanNutricional.php';
        break;
}
