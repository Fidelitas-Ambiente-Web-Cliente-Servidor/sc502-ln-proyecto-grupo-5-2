<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Ejercicio.php';
require_once __DIR__ . '/../models/Rutina.php';
require_once __DIR__ . '/../models/DetalleRutina.php';

class RutinaController
{
    private Ejercicio $modelEjercicio;
    private Rutina $modelRutina;
    private DetalleRutina $modelDetalle;

    public function __construct()
    {
        $database = new Database();
        $this->modelEjercicio = new Ejercicio($database->connect());
        $this->modelRutina = new Rutina($database->connect());
        $this->modelDetalle = new DetalleRutina($database->connect());
    }

    // Carga la vista
    public function index(): void
    {
        require __DIR__ . '/../views/GestionarRutinas.php';
    }

    // Ejercicios
    public function listarEjercicios(): void
    {
        $ejercicios = $this->modelEjercicio->getAll();
        echo json_encode(["ejercicios" => $ejercicios]);
    }

    // Rutinas
    public function listarRutinas(): void
    {
        $rutinas = $this->modelRutina->getAll();
        echo json_encode(["rutinas" => $rutinas]);
    }

    public function crearRutina(): void
    {
        try {
            $id_profesional = (int) ($_POST['id_profesional'] ?? 1);
            $id_paciente    = (int) $_POST['id_paciente'];
            $frecuencia     = (int) $_POST['frecuencia_semanal'];
            $duracion       = !empty($_POST['duracion_total']) ? (int) $_POST['duracion_total'] : null;

            $id_rutina = $this->modelRutina->create($id_profesional, $id_paciente, $frecuencia, $duracion);

            echo json_encode(["response" => "00", "id_rutina" => $id_rutina]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function eliminarRutina(): void
    {
        try {
            $id_rutina = (int) $_POST['id_rutina'];
            $this->modelRutina->delete($id_rutina);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Detalle Rutina
    public function listarDetalles(): void
    {
        $id_rutina = (int) $_GET['id_rutina'];
        $detalles = $this->modelDetalle->getByRutina($id_rutina);
        echo json_encode(["detalles" => $detalles]);
    }

    public function crearDetalle(): void
    {
        try {
            $id_rutina    = (int) $_POST['id_rutina'];
            $id_ejercicio = (int) $_POST['id_ejercicio'];
            $series       = (int) $_POST['series'];
            $repeticiones = (int) $_POST['repeticiones'];

            $this->modelDetalle->create($id_rutina, $id_ejercicio, $series, $repeticiones);

            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function eliminarDetalle(): void
    {
        try {
            $id_detalle = (int) $_POST['id_detalle'];
            $this->modelDetalle->delete($id_detalle);
            echo json_encode(["response" => "00"]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }
}