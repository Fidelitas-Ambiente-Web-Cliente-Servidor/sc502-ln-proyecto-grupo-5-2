<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Expediente.php';

class ExpedienteController
{
    private Expediente $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new Expediente($database->connect());
    }

    // Carga la vista
    public function index(): void
    {
        require __DIR__ . '/../views/GestionPacientes.php';
    }

    // Lista todos los expedientes (GET)
    public function listar(): void
    {
        try {
            $expedientes = $this->model->getAll();
            echo json_encode(["response" => "00", "expedientes" => $expedientes]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function obtener(): void
    {
        try {
            $id_expediente = (int) ($_GET['id'] ?? 0);

            if ($id_expediente <= 0) {
                throw new Exception('Expediente inválido.');
            }

            $expediente = $this->model->getById($id_expediente);

            if (!$expediente) {
                throw new Exception('El expediente no existe.');
            }

            echo json_encode(["response" => "00", "expediente" => $expediente]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function porPaciente(): void
    {
        try {
            $id_paciente = (int) ($_GET['id_paciente'] ?? 0);

            if ($id_paciente <= 0) {
                throw new Exception('Paciente inválido.');
            }

            $expediente = $this->model->getByPaciente($id_paciente);

            echo json_encode(["response" => "00", "expediente" => $expediente]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Crear expediente (POST)
    public function crear(): void
    {
        try {
            $id_paciente    = (int) ($_POST['id_paciente'] ?? 0);
            $historial      = trim($_POST['historial_medico'] ?? '');
            $condiciones    = trim($_POST['condiciones_medicas'] ?? '');
            $alergias       = trim($_POST['alergias'] ?? '');
            $discapacidades = trim($_POST['discapacidades'] ?? '');
            $observaciones  = trim($_POST['observaciones'] ?? '');

            if ($id_paciente <= 0) {
                throw new Exception('Debe seleccionar un paciente.');
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

    // Actualizar expediente (POST)
    public function actualizar(): void
    {
        try {
            $id_expediente  = (int) ($_POST['expedienteId'] ?? 0);
            $historial      = trim($_POST['historial_medico'] ?? '');
            $condiciones    = trim($_POST['condiciones_medicas'] ?? '');
            $alergias       = trim($_POST['alergias'] ?? '');
            $discapacidades = trim($_POST['discapacidades'] ?? '');
            $observaciones  = trim($_POST['observaciones'] ?? '');

            if ($id_expediente <= 0) {
                throw new Exception('Expediente inválido.');
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

    // Eliminar expediente (POST)
    public function eliminar(): void
    {
        try {
            $id_expediente = (int) ($_POST['id_expediente'] ?? 0);

            if ($id_expediente <= 0) {
                throw new Exception('Expediente inválido.');
            }

            $this->model->delete($id_expediente);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}