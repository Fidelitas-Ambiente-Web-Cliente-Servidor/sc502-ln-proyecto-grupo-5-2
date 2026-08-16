<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/PlanNutricional.php';
require_once __DIR__ . '/../models/Cita.php';

class PlanNutricionalController
{
    private PlanNutricional $model;
    private Cita $modelCita;

    public function __construct()
    {
        $database = new Database();
        $conn = $database->connect();
        $this->model = new PlanNutricional($conn);
        $this->modelCita = new Cita($conn);
    }

    public function index(): void
    {
        require __DIR__ . '/../views/GestionarPlanes.php';
    }

    public function listar(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_usuario = (int) $_SESSION['id_usuario'];
            $id_rol = (int) $_SESSION['id_rol'];

            $planes = $this->model->getAll();

            $planes = array_values(array_filter($planes, function ($plan) use ($id_usuario, $id_rol) {
                if ($id_rol === 1) {
                    return isset($plan['id_paciente']) && (int) $plan['id_paciente'] === $id_usuario;
                }
                if ($id_rol === 2) {
                    return isset($plan['id_profesional']) && (int) $plan['id_profesional'] === $id_usuario;
                }
                return false;
            }));

            echo json_encode(["response" => "00", "planes" => $planes]);

        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Lista los pacientes
    public function listarPacientes(): void
    {
        try {

            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede consultar esta lista.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            echo json_encode([
                "response" => "00",
                "pacientes" => $this->modelCita->getPacientesDeProfesional($id_profesional)
            ]);

        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function crear(): void
    {
        try {

            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede crear planes nutricionales.');
            }

            $id_profesional  = (int) $_SESSION['id_usuario'];
            $id_paciente     = (int) ($_POST['id_paciente'] ?? 0);
            $calorias        = (int) ($_POST['calorias_diarias'] ?? 0);
            $recomendaciones = trim($_POST['recomendaciones'] ?? '');
            $fecha_inicio    = trim($_POST['fecha_inicio'] ?? '');
            $fecha_fin       = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;

            $proteinas_g     = !empty($_POST['proteinas_g']) ? (int) $_POST['proteinas_g'] : null;
            $carbohidratos_g = !empty($_POST['carbohidratos_g']) ? (int) $_POST['carbohidratos_g'] : null;
            $grasas_g        = !empty($_POST['grasas_g']) ? (int) $_POST['grasas_g'] : null;
            $agua_litros     = !empty($_POST['agua_litros']) ? (float) $_POST['agua_litros'] : null;

            if ($id_paciente <= 0) {
                throw new Exception('Debe seleccionar un paciente.');
            }

            if (!$this->modelCita->tieneRelacion($id_paciente, $id_profesional)) {
                throw new Exception('Este paciente no ha agendado ninguna cita con usted todavía.');
            }

            if ($recomendaciones === '') {
                throw new Exception('Las recomendaciones son obligatorias.');
            }

            if ($fecha_inicio === '') {
                throw new Exception('Debe indicar la fecha de inicio.');
            }

            $id_plan = $this->model->create(
                $id_profesional,
                $id_paciente,
                $calorias,
                $recomendaciones,
                $fecha_inicio,
                $fecha_fin,
                $proteinas_g,
                $carbohidratos_g,
                $grasas_g,
                $agua_litros
            );

            echo json_encode(["response" => "00", "message" => "Plan creado correctamente.", "id_plan" => $id_plan]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function eliminar(): void
    {
        try {
            $id_plan = (int) ($_POST['id_plan'] ?? 0);

            if ($id_plan <= 0) {
                throw new Exception('Plan inválido.');
            }

            $this->model->delete($id_plan);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Trae el plan nutricional vigente del paciente logueado
    public function obtenerActual(): void
    {
        try {

            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 1) {
                throw new Exception('Solo un paciente puede consultar su plan.');
            }

            $id_paciente = (int) $_SESSION['id_usuario'];
            $plan = $this->model->getUltimoPorPaciente($id_paciente);

            echo json_encode(["response" => "00", "plan" => $plan]);

        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}