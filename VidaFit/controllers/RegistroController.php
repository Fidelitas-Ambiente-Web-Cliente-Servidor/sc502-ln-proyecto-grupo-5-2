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
            $altura_m = (float) ($_POST['altura_m'] ?? 0);
            $peso_ideal = (float) ($_POST['peso_ideal'] ?? 0);
            $medidas_corporales = trim($_POST['medidas_corporales'] ?? '');
            $observaciones_paciente = trim($_POST['observaciones_paciente'] ?? '');
            $fecha_registro = trim($_POST['fecha_registro'] ?? '');

            if ($peso_kg <= 0) {
                throw new Exception('El peso debe ser mayor que cero.');
            }

            $ultimo = $this->model->getLatest($id_paciente);


            if ($altura_m <= 0 && $ultimo && !empty($ultimo['altura_m'])) {
                $altura_m = (float) $ultimo['altura_m'];
            }

            if ($altura_m <= 0) {
                throw new Exception('Indique su altura (se necesita para calcular el IMC); es obligatoria en el primer registro.');
            }

            if ($medidas_corporales === '' && $ultimo && !empty($ultimo['medidas_corporales'])) {
                $medidas_corporales = $ultimo['medidas_corporales'];
            }

            $imc = round($peso_kg / ($altura_m * $altura_m), 2);

            $estado_nutricional = $this->clasificarImc($imc);

            if ($peso_ideal <= 0) {
                $peso_ideal = round(22 * ($altura_m * $altura_m), 1);
            }

            if ($fecha_registro === '') {
                $fecha_registro = date('Y-m-d');
            }

            $id_progreso = $this->model->create(
                $id_paciente,
                $peso_kg,
                $altura_m,
                $imc,
                $peso_ideal,
                $estado_nutricional,
                $medidas_corporales !== '' ? $medidas_corporales : null,
                $observaciones_paciente !== '' ? $observaciones_paciente : null,
                $fecha_registro
            );

            echo json_encode([
                "response" => "00",
                "message" => "Registro guardado correctamente.",
                "id_progreso" => $id_progreso,
                "imc" => $imc,
                "peso_ideal" => $peso_ideal,
                "estado_nutricional" => $estado_nutricional
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function actualizarMedida(): void
    {
        try {

            $id_paciente = (int) $_SESSION['id_usuario'];

            $tipo = trim($_POST['tipo_medida'] ?? '');
            $valor = (float) ($_POST['valor_cm'] ?? 0);

            $tiposValidos = ['Cintura', 'Cadera', 'Brazo', 'Muslo', 'Pecho'];

            if (!in_array($tipo, $tiposValidos, true)) {
                throw new Exception('Tipo de medida no válido.');
            }

            if ($valor <= 0 || $valor > 300) {
                throw new Exception('Ingrese un valor válido en cm (entre 1 y 300).');
            }

            $ultimo = $this->model->getLatest($id_paciente);

            if (!$ultimo) {
                throw new Exception('Registra tu peso al menos una vez antes de agregar medidas.');
            }

            $medidas = [];
            if (!empty($ultimo['medidas_corporales'])) {
                foreach (explode(',', $ultimo['medidas_corporales']) as $par) {
                    $partes = explode(':', $par, 2);
                    if (count($partes) === 2) {
                        $medidas[trim($partes[0])] = trim($partes[1]);
                    }
                }
            }

            $medidas[$tipo] = $valor;

            $serializado = [];
            foreach ($medidas as $k => $v) {
                $serializado[] = $k . ':' . $v;
            }

            $this->model->updateMedidas((int) $ultimo['id_progreso'], implode(',', $serializado));

            echo json_encode([
                "response" => "00",
                "message" => "Medida registrada correctamente.",
                "medidas" => $medidas
            ]);

        } catch (Exception $e) {

            echo json_encode([
                "response" => "01",
                "message" => $e->getMessage()
            ]);
        }
    }

    // IMC
    private function clasificarImc(float $imc): string
    {
        if ($imc < 18.5) {
            return 'Bajo peso';
        }

        if ($imc < 25) {
            return 'Normal';
        }

        if ($imc < 30) {
            return 'Sobrepeso';
        }

        return 'Obesidad';
    }
}