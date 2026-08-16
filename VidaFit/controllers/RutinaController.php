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
        echo json_encode(["response" => "00", "ejercicios" => $ejercicios]);
    }

    // Agrega un ejercicio nuevo al catalogo
    public function crearEjercicio(): void
    {
        try {

            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede agregar ejercicios al catálogo.');
            }

            $nombre = trim($_POST['nombre_ejercicio'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $video_url = trim($_POST['video_url'] ?? '');

            if ($nombre === '') {
                throw new Exception('El nombre del ejercicio es obligatorio.');
            }

            $id_ejercicio = $this->modelEjercicio->create(
                $nombre,
                $descripcion !== '' ? $descripcion : null,
                $video_url !== '' ? $video_url : null
            );

            echo json_encode(["response" => "00", "message" => "Ejercicio agregado al catálogo.", "id_ejercicio" => $id_ejercicio]);
        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    // Rutinas
    public function listarRutinas(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_usuario = (int) $_SESSION['id_usuario'];
            $id_rol = (int) $_SESSION['id_rol'];

            if ($id_rol === 1) {
                $rutinas = $this->modelRutina->getByPaciente($id_usuario);
            } elseif ($id_rol === 2) {
                $rutinas = $this->modelRutina->getByProfesional($id_usuario);
            } else {
                throw new Exception('Rol no válido.');
            }

            echo json_encode(["response" => "00", "rutinas" => $rutinas]);

        } catch (Exception $e) {
            echo json_encode(["response" => "01", "message" => $e->getMessage()]);
        }
    }

    public function crearRutina(): void
    {
        try {
            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede crear rutinas.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];
            $id_paciente    = (int) ($_POST['id_paciente'] ?? 0);
            $frecuencia     = (int) ($_POST['frecuencia_semanal'] ?? 0);
            $duracion       = !empty($_POST['duracion_total']) ? (int) $_POST['duracion_total'] : null;

            if ($id_paciente <= 0) {
                throw new Exception('Debe seleccionar un paciente.');
            }

            if ($frecuencia <= 0) {
                throw new Exception('La frecuencia semanal debe ser mayor que cero.');
            }

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
        $id_rutina = (int) ($_GET['id_rutina'] ?? 0);
        $detalles = $id_rutina > 0 ? $this->modelDetalle->getByRutina($id_rutina) : [];
        echo json_encode(["response" => "00", "detalles" => $detalles]);
    }

    public function crearDetalle(): void
    {
        try {
            $id_rutina    = (int) ($_POST['id_rutina'] ?? 0);
            $id_ejercicio = (int) ($_POST['id_ejercicio'] ?? 0);
            $series       = (int) ($_POST['series'] ?? 0);
            $repeticiones = (int) ($_POST['repeticiones'] ?? 0);

            $dia_rutina          = trim($_POST['dia_rutina'] ?? '');
            $descanso_segundos   = !empty($_POST['descanso_segundos']) ? (int) $_POST['descanso_segundos'] : null;
            $nivel_dificultad    = trim($_POST['nivel_dificultad'] ?? '');
            $calorias_por_sesion = !empty($_POST['calorias_por_sesion']) ? (int) $_POST['calorias_por_sesion'] : null;

            if ($id_rutina <= 0 || $id_ejercicio <= 0) {
                throw new Exception('Seleccione una rutina y un ejercicio válidos.');
            }

            if ($series <= 0 || $repeticiones <= 0) {
                throw new Exception('Series y repeticiones deben ser mayores que cero.');
            }

            if ($dia_rutina === '') {
                throw new Exception('Indique a qué día o sesión pertenece este ejercicio.');
            }

            $this->modelDetalle->create(
                $id_rutina,
                $id_ejercicio,
                $series,
                $repeticiones,
                $dia_rutina,
                $descanso_segundos,
                $nivel_dificultad !== '' ? $nivel_dificultad : null,
                $calorias_por_sesion
            );

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