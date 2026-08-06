<?php
require_once './controllers/PlanNutricionalController.php';
require_once './controllers/PlanComidaController.php';

$page = $_GET['page'] ?? 'GestionarPlanes';

// ─── PETICIONES GET ──────────────────────────────────────
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

// ─── PETICIONES POST ─────────────────────────────────────
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

// ─── CARGAR VISTAS ──────────────────────────────────────
switch ($page) {
    case 'GestionarPlanes':
        $controller = new PlanNutricionalController();
        $controller->index();
        break;

    default:
        $controller = new PlanNutricionalController();
        $controller->index();
        break;
}
