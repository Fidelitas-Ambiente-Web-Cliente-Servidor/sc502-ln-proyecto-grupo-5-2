<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Expediente.php';
require_once __DIR__ . '/../models/Cita.php';

class ExpedienteController
{
    private Expediente $model;
    private Cita $modelCita;

    public function __construct()
    {
        $database = new Database();
        $conn = $database->connect();
        $this->model = new Expediente($conn);
        $this->modelCita = new Cita($conn);
    }

    // Carga la vista
    public function index(): void
    {
        require __DIR__ . '/../views/GestionPacientes.php';
    }

    // Lista los expedientes de "mis pacientes" (GET).
    public function listar(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede consultar expedientes.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            $expedientes = $this->model->getAllDeProfesional($id_profesional);
            echo json_encode(["response" => "00", "expedientes" => $expedientes]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Buscar un expediente puntual por su propio id_expediente
    public function obtener(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede consultar expedientes.');
            }

            $id_expediente = (int) ($_GET['id'] ?? 0);

            if ($id_expediente <= 0) {
                throw new Exception('Expediente inválido.');
            }

            $expediente = $this->model->getById($id_expediente);

            if (!$expediente) {
                throw new Exception('El expediente no existe.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            if (!$this->modelCita->tieneRelacion((int) $expediente['id_paciente'], $id_profesional)) {
                throw new Exception('Este expediente no pertenece a uno de sus pacientes.');
            }

            echo json_encode(["response" => "00", "expediente" => $expediente]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Buscar el expediente de un paciente
    public function porPaciente(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede consultar expedientes.');
            }

            $id_paciente = (int) ($_GET['id_paciente'] ?? 0);

            if ($id_paciente <= 0) {
                throw new Exception('Paciente inválido.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            if (!$this->modelCita->tieneRelacion($id_paciente, $id_profesional)) {
                throw new Exception('Este paciente no ha agendado ninguna cita con usted todavía.');
            }

            $expediente = $this->model->getByPaciente($id_paciente);

            echo json_encode(["response" => "00", "expediente" => $expediente]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Crea expediente (POST).
    public function crear(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede registrar expedientes.');
            }

            $id_paciente    = (int) ($_POST['id_paciente'] ?? 0);
            $historial      = trim($_POST['historial_medico'] ?? '');
            $condiciones    = trim($_POST['condiciones_medicas'] ?? '');
            $alergias       = trim($_POST['alergias'] ?? '');
            $discapacidades = trim($_POST['discapacidades'] ?? '');
            $observaciones  = trim($_POST['observaciones'] ?? '');

            if ($id_paciente <= 0) {
                throw new Exception('Debe seleccionar un paciente.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            if (!$this->modelCita->tieneRelacion($id_paciente, $id_profesional)) {
                throw new Exception('Este paciente no ha agendado ninguna cita con usted todavía.');
            }

            if ($historial === '' || $condiciones === '' || $alergias === '' || $discapacidades === '' || $observaciones === '') {
                throw new Exception('Todos los campos del expediente son obligatorios (escriba "Ninguna" si no aplica).');
            }

            if ($this->model->getByPaciente($id_paciente)) {
                throw new Exception('Este paciente ya tiene un expediente. Use la opción de editar en vez de crear uno nuevo.');
            }

            $this->model->create($id_paciente, $historial, $condiciones, $alergias, $discapacidades, $observaciones);

            echo json_encode(["response" => "00", "message" => "Expediente creado correctamente."]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Actualiza expediente (POST).
    public function actualizar(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede actualizar expedientes.');
            }

            $id_expediente  = (int) ($_POST['expedienteId'] ?? 0);
            $historial      = trim($_POST['historial_medico'] ?? '');
            $condiciones    = trim($_POST['condiciones_medicas'] ?? '');
            $alergias       = trim($_POST['alergias'] ?? '');
            $discapacidades = trim($_POST['discapacidades'] ?? '');
            $observaciones  = trim($_POST['observaciones'] ?? '');

            if ($id_expediente <= 0) {
                throw new Exception('Expediente inválido.');
            }

            $expediente = $this->model->getById($id_expediente);

            if (!$expediente) {
                throw new Exception('El expediente no existe.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            if (!$this->modelCita->tieneRelacion((int) $expediente['id_paciente'], $id_profesional)) {
                throw new Exception('Este expediente no pertenece a uno de sus pacientes.');
            }

            if ($historial === '' || $condiciones === '' || $alergias === '' || $discapacidades === '' || $observaciones === '') {
                throw new Exception('Todos los campos del expediente son obligatorios (escriba "Ninguna" si no aplica).');
            }

            $this->model->update($id_expediente, $historial, $condiciones, $alergias, $discapacidades, $observaciones);

            echo json_encode(["response" => "00", "message" => "Expediente actualizado correctamente."]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Elimina expediente (POST).
    public function eliminar(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede eliminar expedientes.');
            }

            $id_expediente = (int) ($_POST['id_expediente'] ?? 0);

            if ($id_expediente <= 0) {
                throw new Exception('Expediente inválido.');
            }

            $expediente = $this->model->getById($id_expediente);

            if (!$expediente) {
                throw new Exception('El expediente no existe.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            if (!$this->modelCita->tieneRelacion((int) $expediente['id_paciente'], $id_profesional)) {
                throw new Exception('Este expediente no pertenece a uno de sus pacientes.');
            }

            $this->model->delete($id_expediente);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}