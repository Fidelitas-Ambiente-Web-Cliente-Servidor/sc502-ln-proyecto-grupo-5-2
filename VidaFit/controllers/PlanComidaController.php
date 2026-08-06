<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/PlanComida.php';

class PlanComidaController
{
    private PlanComida $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new PlanComida($database->connect());
    }

    public function listar(): void
    {
        $id_plan = (int) $_GET['id_plan'];
        $comidas = $this->model->getByPlan($id_plan);
        echo json_encode(["comidas" => $comidas]);
    }

    public function crear(): void
    {
        try {
            $id_plan    = (int) $_POST['id_plan'];
            $nombre     = $_POST['nombre_comida'];
            $horario    = $_POST['horario'] ?? null;
            $descripcion= $_POST['descripcion_alimentos'];

            $this->model->create($id_plan, $nombre, $horario, $descripcion);

            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function eliminar(): void
    {
        try {
            $id_comida = (int) $_POST['id_comida'];
            $this->model->delete($id_comida);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}