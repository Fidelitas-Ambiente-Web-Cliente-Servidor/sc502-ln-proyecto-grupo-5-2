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
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_plan = (int) ($_GET['id_plan'] ?? 0);

            if ($id_plan <= 0) {
                throw new Exception('Plan inválido.');
            }

            $database = new Database();
            $conn = $database->connect();

            $stmt = $conn->prepare(
                'SELECT id_paciente, id_profesional FROM planes_nutricionales WHERE id_plan = ?'
            );
            $stmt->execute([$id_plan]);
            $plan = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$plan) {
                throw new Exception('El plan no existe.');
            }

            $id_usuario = (int) $_SESSION['id_usuario'];

            if ((int) $plan['id_paciente'] !== $id_usuario && (int) $plan['id_profesional'] !== $id_usuario) {
                throw new Exception('No tiene permiso para ver este plan.');
            }

            $comidas = $this->model->getByPlan($id_plan);

            echo json_encode(["response" => "00", "comidas" => $comidas]);

        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function crear(): void
    {
        try {
            $id_plan     = (int) ($_POST['id_plan'] ?? 0);
            $nombre      = trim($_POST['nombre_comida'] ?? '');
            $horario     = $_POST['horario'] ?? null;
            $descripcion = trim($_POST['descripcion_alimentos'] ?? '');
            $dia_semana  = trim($_POST['dia_semana'] ?? '');

            $diasValidos = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

            if ($id_plan <= 0) {
                throw new Exception('Plan inválido.');
            }

            if ($nombre === '') {
                throw new Exception('El nombre de la comida es obligatorio.');
            }

            if ($descripcion === '') {
                throw new Exception('La descripción de alimentos es obligatoria.');
            }

            if ($dia_semana !== '' && !in_array($dia_semana, $diasValidos, true)) {
                throw new Exception('Día de la semana no válido.');
            }

            $this->model->create($id_plan, $nombre, $horario, $descripcion, $dia_semana !== '' ? $dia_semana : null);

            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function eliminar(): void
    {
        try {
            $id_comida = (int) ($_POST['id_comida'] ?? 0);

            if ($id_comida <= 0) {
                throw new Exception('Comida inválida.');
            }

            $this->model->delete($id_comida);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}