<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/PlanNutricional.php';

class PlanNutricionalController
{
    private PlanNutricional $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new PlanNutricional($database->connect());
    }

    public function index(): void
    {
        require __DIR__ . '/../views/GestionarPlanes.php';
    }

    public function listar(): void
    {
        $planes = $this->model->getAll();
        echo json_encode(["planes" => $planes]);
    }

    public function crear(): void
    {
        try {
            $id_profesional = (int) ($_POST['id_profesional'] ?? 1);
            $id_paciente    = (int) $_POST['id_paciente'];
            $calorias       = (int) ($_POST['calorias_diarias'] ?? 0);
            $recomendaciones= $_POST['recomendaciones'];
            $fecha_inicio   = $_POST['fecha_inicio'];
            $fecha_fin      = $_POST['fecha_fin'] ?? null;

            $this->model->create($id_profesional, $id_paciente, $calorias, $recomendaciones, $fecha_inicio, $fecha_fin);

            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function eliminar(): void
    {
        try {
            $id_plan = (int) $_POST['id_plan'];
            $this->model->delete($id_plan);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}