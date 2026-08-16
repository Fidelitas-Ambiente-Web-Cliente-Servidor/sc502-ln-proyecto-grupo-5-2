<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Cita.php';

class CitaController
{
    private Cita $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new Cita($database->connect());
    }

    // Proxima cita del paciente logueado
    public function obtenerProxima(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_paciente = (int) $_SESSION['id_usuario'];

            $cita = $this->model->getProximaByPaciente($id_paciente);

            echo json_encode([
                "response" => "00",
                "cita" => $cita
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Listado de citas del paciente logueado
    public function listarPaciente(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_paciente = (int) $_SESSION['id_usuario'];

            $citas = $this->model->getAllByPaciente($id_paciente);

            echo json_encode([
                "response" => "00",
                "citas" => $citas
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Listado de citas agendadas por el profesional logueado
    public function listarProfesional(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            $citas = $this->model->getAllByProfesional($id_profesional);

            echo json_encode([
                "response" => "00",
                "citas" => $citas
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    // El paciente agenda una cita con un profesional
    public function crear(): void
    {
        try {

            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 1) {
                throw new Exception('Solo un paciente puede agendar su propia cita.');
            }

            $id_paciente = (int) $_SESSION['id_usuario'];
            $id_profesional = (int) ($_POST['id_profesional'] ?? 0);
            $fecha = trim($_POST['fecha'] ?? '');
            $hora = trim($_POST['hora'] ?? '');
            $motivo = trim($_POST['motivo'] ?? '');

            if ($id_profesional <= 0) {
                throw new Exception('Debe seleccionar un profesional.');
            }

            if ($fecha === '' || $hora === '') {
                throw new Exception('Debe indicar fecha y hora.');
            }

            if (strlen($motivo) < 10) {
                throw new Exception('Describa el motivo de la cita (mínimo 10 caracteres).');
            }

            $id_cita = $this->model->create(
                $id_profesional,
                $id_paciente,
                $fecha,
                $hora,
                $motivo
            );

            echo json_encode([
                "response" => "00",
                "message" => "Cita agendada correctamente.",
                "id_cita" => $id_cita
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Cancelar una cita (solo el paciente o el profesional)
    public function cancelar(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_cita = (int) ($_POST['id_cita'] ?? 0);

            if ($id_cita <= 0) {
                throw new Exception('Cita inválida.');
            }

            $cita = $this->model->getById($id_cita);

            if (!$cita) {
                throw new Exception('La cita no existe.');
            }

            $id_usuario = (int) $_SESSION['id_usuario'];

            if ((int) $cita['id_paciente'] !== $id_usuario && (int) $cita['id_profesional'] !== $id_usuario) {
                throw new Exception('No tiene permiso para cancelar esta cita.');
            }

            $resultado = $this->model->cambiarEstado($id_cita, 'Cancelada');

            if (!$resultado) {
                throw new Exception('No se pudo cancelar la cita.');
            }

            echo json_encode([
                "response" => "00",
                "message" => "Cita cancelada."
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    // Lista de profesionales para poblar el select del formulario de citas
    public function listarProfesionales(): void
    {
        try {

            $profesionales = $this->model->getProfesionalesDisponibles();

            echo json_encode([
                "response" => "00",
                "profesionales" => $profesionales
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }
}