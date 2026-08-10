<?php
class User
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function login(string $username): array|false
    {
        $stmt = $this->conn->prepare(
            'SELECT * FROM usuarios WHERE username = ? LIMIT 1'
        );
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function usernameExists(string $username): bool
    {
        $stmt = $this->conn->prepare(
            'SELECT id_usuario FROM usuarios WHERE username = ? LIMIT 1'
        );
        $stmt->execute([$username]);
        return $stmt->rowCount() > 0;
    }

    public function register(string $nombre_completo, string $username, string $correo, string $contrasenna,int $id_rol): bool
    { 
        $hash = password_hash($contrasenna, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            'INSERT INTO usuarios (nombre_completo, username, correo, contrasenna, id_rol) VALUES (?, ?, ?, ?, ?)'
        );
        return $stmt->execute([$nombre_completo, $username,$correo, $hash, $id_rol]);
    }

      public function assignRole(int $id_usuario, int $id_rol): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE usuarios
             SET id_rol = ?
             WHERE id_usuario = ?'
        );

        return $stmt->execute([
            $id_rol,
            $id_usuario
        ]);
    }
}

