<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
class UserController
{
    private User $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new User($database->connect());
    }

    public function showLogin(): void
    {
        require __DIR__ . '/../views/login.php';
    }

    public function showRegister(): void
    {
        require __DIR__ . '/../views/register.php';
    }

    public function login(): void
{
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode([
            'response' => '01',
            'message' => 'Usuario y contraseña son obligatorios'
        ]);
        return;
    }

    $user = $this->model->login($username);

    if ($user && password_verify($password, $user['contrasenna'])) {

        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nombre_completo'] = $user['nombre_completo'];
        $_SESSION['id_rol'] = $user['id_rol'];

        echo json_encode([
            'response' => '00',
            'message' => 'Login exitoso',
            'id_rol' => $user['id_rol']
        ]);

        return;
    }

    echo json_encode([
        'response' => '01',
        'message' => 'Usuario o contraseña incorrectos'
    ]);
}

    public function register(): void
    {
        $nombre_completo = trim($_POST['nombre_completo'] ?? '');
        $username        = trim($_POST['username'] ?? '');
        $correo          = trim($_POST['correo'] ?? '');
        $password        = $_POST['password'] ?? '';
        $confirm         = $_POST['confirm_password'] ?? '';
        $id_rol          = (int) ($_POST['id_rol'] ?? 0);

        // Valida campos obligatorios
        if (
            empty($nombre_completo) ||
            empty($username) ||
            empty($correo) ||
            empty($password) ||
            empty($id_rol)
        ) {
            echo json_encode([
                'response' => '01',
                'message' => 'Todos los campos son obligatorios'
            ]);
            return;
        }

        // Valida confirmación de contraseña
        if ($password !== $confirm) {
            echo json_encode([
                'response' => '02',
                'message' => 'Las contraseñas no coinciden'
            ]);
            return;
        }

        // Valida un usuario existente
        if ($this->model->usernameExists($username)) {
            echo json_encode([
                'response' => '03',
                'message' => 'El nombre de usuario ya existe'
            ]);
            return;
        }

        // Roles permitidos en el registro público. (1: paciente, 2: profesional)
       
        if (!in_array($id_rol, [1, 2], true)) {
            echo json_encode([
                'response' => '04',
                'message' => 'Rol no válido'
            ]);
            return;
        }

        $resultado = $this->model->register(
            $nombre_completo,
            $username,
            $correo,
            $password,
            $id_rol
        );

        if ($resultado) {
            echo json_encode([
                'response' => '00',
                'message' => 'Registro exitoso'
            ]);
        } else {
            echo json_encode([
                'response' => '05',
                'message' => 'No se pudo registrar el usuario'
            ]);
        }
    }

    public function logout(): void
    {
        session_destroy();

        echo json_encode([
            'response' => '00',
            'message' => 'Sesión cerrada'
        ]);
    }

    public function obtenerUsuarioActual(): void
{
    try {

        if (!isset($_SESSION['id_usuario'])) {

            echo json_encode([
                'response' => '01',
                'message' => 'No hay una sesión activa'
            ]);

            return;
        }


        $id_usuario = (int) $_SESSION['id_usuario'];

        $usuario = $this->model->getById($id_usuario);


        if (!$usuario) {

            echo json_encode([
                'response' => '02',
                'message' => 'Usuario no encontrado'
            ]);

            return;
        }

        unset($usuario['contrasenna']);

        echo json_encode([
            'response' => '00',
            'usuario' => $usuario
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'response' => '01',
            'message' => $e->getMessage()
        ]);
    }
}

public function cambiarContrasenna(): void
{
    try {

        if (!isset($_SESSION['id_usuario'])) {
            throw new Exception('No hay una sesión activa.');
        }

        $id_usuario = (int) $_SESSION['id_usuario'];

        $actual = $_POST['contrasenna_actual'] ?? '';
        $nueva = $_POST['nueva_contrasenna'] ?? '';
        $confirmar = $_POST['confirmar_contrasenna'] ?? '';

        if ($actual === '' || $nueva === '' || $confirmar === '') {
            throw new Exception('Debe completar todos los campos.');
        }

        if ($nueva !== $confirmar) {
            throw new Exception('Las contraseñas no coinciden.');
        }

        if (strlen($nueva) < 8) {
            throw new Exception(
                'La contraseña debe tener al menos 8 caracteres.'
            );
        }

        $usuario = $this->model->getById($id_usuario);

        if (!$usuario || !password_verify($actual, $usuario['contrasenna'])) {
            throw new Exception('La contraseña actual no es correcta.');
        }

        $resultado = $this->model->cambiarContrasenna(
            $id_usuario,
            $nueva
        );

        if (!$resultado) {
            throw new Exception(
                'No se pudo actualizar la contraseña.'
            );
        }

        echo json_encode([
            'response' => '00',
            'message' => 'Contraseña actualizada correctamente.'
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'response' => '01',
            'message' => $e->getMessage()
        ]);
    }
}

    public function actualizarPerfil(): void
    {
        try {

            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('No hay una sesión activa.');
            }

            $id_usuario = (int) $_SESSION['id_usuario'];
            $nombre_completo = trim($_POST['nombre_completo'] ?? '');
            $correo = trim($_POST['correo'] ?? '');

            if ($nombre_completo === '') {
                throw new Exception('El nombre completo es obligatorio.');
            }

            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Ingrese un correo electrónico válido.');
            }

            $database = new Database();
            $conn = $database->connect();

            $stmtCheck = $conn->prepare(
                'SELECT id_usuario FROM usuarios WHERE correo = ? AND id_usuario != ?'
            );
            $stmtCheck->execute([$correo, $id_usuario]);

            if ($stmtCheck->fetch()) {
                throw new Exception('Ese correo ya está en uso por otro usuario.');
            }

            $stmt = $conn->prepare(
                'UPDATE usuarios SET nombre_completo = ?, correo = ? WHERE id_usuario = ?'
            );
            $stmt->execute([$nombre_completo, $correo, $id_usuario]);

            $_SESSION['nombre_completo'] = $nombre_completo;

            echo json_encode([
                'response' => '00',
                'message' => 'Perfil actualizado correctamente.'
            ]);

        } catch (Exception $e) {

            echo json_encode([
                'response' => '01',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function estadisticasProfesional(): void
    {
        try {

            if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_rol'] !== 2) {
                throw new Exception('Solo un profesional puede ver estas estadísticas.');
            }

            $id_profesional = (int) $_SESSION['id_usuario'];

            $database = new Database();
            $conn = $database->connect();

            $stmtPacientes = $conn->prepare(
                'SELECT COUNT(DISTINCT id_paciente) FROM citas WHERE id_profesional = ?'
            );
            $stmtPacientes->execute([$id_profesional]);
            $pacientesActivos = (int) $stmtPacientes->fetchColumn();

            $stmtCitasHoy = $conn->prepare(
                'SELECT COUNT(*) FROM citas WHERE id_profesional = ? AND fecha = CURDATE() AND estado != "Cancelada"'
            );
            $stmtCitasHoy->execute([$id_profesional]);
            $citasHoy = (int) $stmtCitasHoy->fetchColumn();

            $stmtRutinas = $conn->prepare(
                'SELECT COUNT(*) FROM rutinas WHERE id_profesional = ?'
            );
            $stmtRutinas->execute([$id_profesional]);
            $rutinasAsignadas = (int) $stmtRutinas->fetchColumn();

            $stmtPlanes = $conn->prepare(
                'SELECT COUNT(*) FROM planes_nutricionales WHERE id_profesional = ?'
            );
            $stmtPlanes->execute([$id_profesional]);
            $planesActivos = (int) $stmtPlanes->fetchColumn();

            echo json_encode([
                'response' => '00',
                'pacientesActivos' => $pacientesActivos,
                'citasHoy' => $citasHoy,
                'rutinasAsignadas' => $rutinasAsignadas,
                'planesActivos' => $planesActivos
            ]);

        } catch (Exception $e) {

            echo json_encode([
                'response' => '01',
                'message' => $e->getMessage()
            ]);
        }
    }
}