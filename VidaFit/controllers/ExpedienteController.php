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
        $expedientes = $this->model->getAll();
        echo json_encode(["expedientes" => $expedientes]);
    }

    // Crear expediente (POST)
    public function crear(): void
    {
        try {
            $id_paciente    = (int) $_POST['id_paciente'];
            $historial      = $_POST['historial_medico'];
            $condiciones    = $_POST['condiciones_medicas'];
            $alergias       = $_POST['alergias'];
            $discapacidades = $_POST['discapacidades'];
            $observaciones  = $_POST['observaciones'];

            $this->model->create($id_paciente, $historial, $condiciones, $alergias, $discapacidades, $observaciones);

            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Actualizar expediente (POST)
    public function actualizar(): void
    {
        try {
            $id_expediente  = (int) $_POST['expedienteId'];
            $historial      = $_POST['historial_medico'];
            $condiciones    = $_POST['condiciones_medicas'];
            $alergias       = $_POST['alergias'];
            $discapacidades = $_POST['discapacidades'];
            $observaciones  = $_POST['observaciones'];

            $this->model->update($id_expediente, $historial, $condiciones, $alergias, $discapacidades, $observaciones);

            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Eliminar expediente (POST)
    public function eliminar(): void
    {
        try {
            $id_expediente = (int) $_POST['id_expediente'];
            $this->model->delete($id_expediente);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}