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

        // Validar campos obligatorios
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

        // Validar confirmación de contraseña
        if ($password !== $confirm) {
            echo json_encode([
                'response' => '02',
                'message' => 'Las contraseñas no coinciden'
            ]);
            return;
        }

        // Validar usuario existente
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

        $nueva = $_POST['nueva_contrasenna'] ?? '';
        $confirmar = $_POST['confirmar_contrasenna'] ?? '';

        if ($nueva === '' || $confirmar === '') {
            throw new Exception('Debe completar ambos campos.');
        }

        if ($nueva !== $confirmar) {
            throw new Exception('Las contraseñas no coinciden.');
        }

        if (strlen($nueva) < 8) {
            throw new Exception(
                'La contraseña debe tener al menos 8 caracteres.'
            );
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
}