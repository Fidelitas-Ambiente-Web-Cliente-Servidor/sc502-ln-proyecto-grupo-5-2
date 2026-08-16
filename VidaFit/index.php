<?php
session_start();

require_once './controllers/PlanNutricionalController.php';
require_once './controllers/PlanComidaController.php';
require_once './controllers/ExpedienteController.php';
require_once './controllers/RutinaController.php';
require_once './controllers/UserController.php';
require_once './controllers/RegistroController.php';
require_once './controllers/CitaController.php';

$page = $_GET['page'] ?? 'login';

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

    if (($_GET['option'] ?? '') === 'listarPacientes') {
        $controller = new PlanNutricionalController();
        $controller->listarPacientes();
        exit;
    }

    if (($_GET['option'] ?? '') === 'obtenerPlanActual') {
        $controller = new PlanNutricionalController();
        $controller->obtenerActual();
        exit;
    }

    if (($_GET['option'] ?? '') === 'listarExpedientes') {
        $controller = new ExpedienteController();
        $controller->listar();
        exit;
    }

    if (($_GET['option'] ?? '') === 'obtenerExpedientePorPaciente') {
        $controller = new ExpedienteController();
        $controller->porPaciente();
        exit;
    }

    if (($_GET['option'] ?? '') === 'obtenerExpediente') {
        $controller = new ExpedienteController();
        $controller->obtener();
        exit;
    }

    if (($_GET['option'] ?? '') === 'listarProgreso') {

    $controller = new RegistroController();
    $controller->listar();

    exit;
}

if (($_GET['option'] ?? '') === 'obtenerUsuarioActual') {

    $controller = new UserController();
    $controller->obtenerUsuarioActual();

    exit;
}

if (($_GET['option'] ?? '') === 'estadisticasProfesional') {

    $controller = new UserController();
    $controller->estadisticasProfesional();

    exit;
}

if (($_GET['option'] ?? '') === 'obtenerProgresoActual') {

    $controller = new RegistroController();
    $controller->obtenerActual();

    exit;
}

if (($_GET['option'] ?? '') === 'obtenerProximaCita') {

    $controller = new CitaController();
    $controller->obtenerProxima();

    exit;
}

if (($_GET['option'] ?? '') === 'listarCitasPaciente') {

    $controller = new CitaController();
    $controller->listarPaciente();

    exit;
}

if (($_GET['option'] ?? '') === 'listarCitasProfesional') {

    $controller = new CitaController();
    $controller->listarProfesional();

    exit;
}

if (($_GET['option'] ?? '') === 'listarProfesionales') {

    $controller = new CitaController();
    $controller->listarProfesionales();

    exit;
}

if (($_GET['option'] ?? '') === 'listarEjercicios') {

    $controller = new RutinaController();
    $controller->listarEjercicios();

    exit;
}

if (($_GET['option'] ?? '') === 'listarRutinas') {

    $controller = new RutinaController();
    $controller->listarRutinas();

    exit;
}

if (($_GET['option'] ?? '') === 'listarDetalles') {

    $controller = new RutinaController();
    $controller->listarDetalles();

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

    if (($_POST['option'] ?? '') === 'cambiarContrasenna') {

    $controller = new UserController();
    $controller->cambiarContrasenna();

    exit;
}

    if (($_POST['option'] ?? '') === 'actualizarPerfil') {

    $controller = new UserController();
    $controller->actualizarPerfil();

    exit;
}

    if (($_POST['option'] ?? '') === 'crearExpediente') {

    $controller = new ExpedienteController();
    $controller->crear();

    exit;
}

    if (($_POST['option'] ?? '') === 'actualizarExpediente') {

    $controller = new ExpedienteController();
    $controller->actualizar();

    exit;
}

    if (($_POST['option'] ?? '') === 'eliminarExpediente') {

    $controller = new ExpedienteController();
    $controller->eliminar();

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

    if (($_POST['option'] ?? '') === 'crearProgreso') {

    $controller = new RegistroController();
    $controller->crear();

    exit;
}

    if (($_POST['option'] ?? '') === 'actualizarMedida') {

    $controller = new RegistroController();
    $controller->actualizarMedida();

    exit;
}

    if (($_POST['option'] ?? '') === 'crearCita') {

    $controller = new CitaController();
    $controller->crear();

    exit;
}

    if (($_POST['option'] ?? '') === 'cancelarCita') {

    $controller = new CitaController();
    $controller->cancelar();

    exit;
}

    if (($_POST['option'] ?? '') === 'crearRutina') {

    $controller = new RutinaController();
    $controller->crearRutina();

    exit;
}

    if (($_POST['option'] ?? '') === 'crearEjercicio') {

    $controller = new RutinaController();
    $controller->crearEjercicio();

    exit;
}

    if (($_POST['option'] ?? '') === 'eliminarRutina') {

    $controller = new RutinaController();
    $controller->eliminarRutina();

    exit;
}

    if (($_POST['option'] ?? '') === 'crearDetalle') {

    $controller = new RutinaController();
    $controller->crearDetalle();

    exit;
}

    if (($_POST['option'] ?? '') === 'eliminarDetalle') {

    $controller = new RutinaController();
    $controller->eliminarDetalle();

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

        if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
            header('Location: index.php?page=login');
            exit;
        }

        $controller = new PlanNutricionalController();
        $controller->index();

        break;

    case 'GestionPacientes':

        if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
            header('Location: index.php?page=login');
            exit;
        }

        $controller = new ExpedienteController();
        $controller->index();
        break;

    case 'GestionarRutinas':

        if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
            header('Location: index.php?page=login');
            exit;
        }

        $controller = new RutinaController();
        $controller->index();

        break;

    case 'Rutinas':
        require_once __DIR__ . '/views/rutinas.php';
        break;

      case 'Miprogreso':
        require_once __DIR__ . '/views/Miprogreso.php';
        break;

    case 'Configuracion':
    require_once __DIR__ . '/views/Configuracion.php';
    break;

    case 'ConfiguracionProfesional':

    if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
        header('Location: index.php?page=login');
        exit;
    }

    require_once __DIR__ . '/views/ConfiguracionProfesional.php';
    break;

    case 'Citas':
    require_once __DIR__ . '/views/Citas.php';
    break;

    case 'Perfil':

    if (!isset($_SESSION['id_usuario'])) {
        header('Location: index.php?page=login');
        exit;
    }

    require_once __DIR__ . '/views/perfil.php';
    break;

      case 'PlanNutricional':
        require_once __DIR__ . '/views/PlanNutricional.php';
        break;

    default:
    
    header('Location: index.php?page=login');
    exit;


}