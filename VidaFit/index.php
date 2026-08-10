<?php
session_start();

require_once './controllers/PlanNutricionalController.php';
require_once './controllers/PlanComidaController.php';
require_once './controllers/ExpedienteController.php';
require_once './controllers/RutinaController.php';
require_once './controllers/UserController.php';

$page = $_GET['page'] ?? 'register';

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

if (($_POST['option'] ?? '') === 'login') {
        $controller = new UserController();
        $controller->login();
        exit;
    }
    
  if (($_POST['option'] ?? '') === 'logout') {
        $controller = new UserController();
        $controller->logout();
        exit;
    }


    if (($_POST['option'] ?? '') === 'register') {
        $controller = new UserController();
        $controller->register();
        exit;
    }

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

 case 'login':
        $controller = new UserController();
        $controller->showLogin();
        break;

    case 'register':
        $controller = new UserController();
        $controller->showRegister();
        break;

     case 'indexPaciente':

         if (!isset($_SESSION['id_usuario'])) {
        header('Location: index.php?page=login');
        exit;
    }

    if ((int) $_SESSION['id_rol'] !== 1) {
        header('Location: index.php?page=login');
        exit;
    }
        require_once __DIR__ . '/views/indexPaciente.php';
        break;

    case 'indexProfesional':

        if (!isset($_SESSION['id_usuario'])) {
        header('Location: index.php?page=login');
        exit;
    }

    if ((int) $_SESSION['id_rol'] !== 2) {
        header('Location: index.php?page=login');
        exit;
    }
        require_once __DIR__ . '/views/indexProfesional.php';
        break;

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
