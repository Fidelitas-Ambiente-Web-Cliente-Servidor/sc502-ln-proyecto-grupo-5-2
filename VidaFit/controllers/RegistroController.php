<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Registro.php';

class RegistroController
{
    private Registro $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new Registro($database->connect());
    }

    public function index(): void
    {
        require __DIR__ . '/../views/ProgresoPaciente.php';
    }

    public function listar(): void
    {
        try {

            $id_paciente = (int) $_SESSION['id_usuario'];

            $registros = $this->model->getAll($id_paciente);

            echo json_encode([
                "response" => "00",
                "registros" => $registros
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function obtenerActual(): void
    {
        try {

            $id_paciente = (int) $_SESSION['id_usuario'];

            $registro = $this->model->getLatest($id_paciente);

            echo json_encode([
                "response" => "00",
                "registro" => $registro
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function crear(): void
    {
        try {

            $id_paciente = (int) $_SESSION['id_usuario'];

            $peso_kg = (float) ($_POST['peso_kg'] ?? 0);
            $imc = (float) ($_POST['imc'] ?? 0);
            $peso_ideal = (float) ($_POST['peso_ideal'] ?? 0);

            if ($peso_kg <= 0) {
                throw new Exception('El peso debe ser mayor que cero.');
            }

            if ($imc <= 0) {
                throw new Exception('El IMC debe ser mayor que cero.');
            }

            if ($peso_ideal <= 0) {
                throw new Exception('El peso ideal debe ser mayor que cero.');
            }

            $id_progreso = $this->model->create(
                $id_paciente,
                $peso_kg,
                $imc,
                $peso_ideal
            );

            echo json_encode([
                "response" => "00",
                "message" => "Registro guardado correctamente.",
                "id_progreso" => $id_progreso
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }
}