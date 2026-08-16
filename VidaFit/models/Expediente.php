<?php
class Expediente
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query(
            'SELECT e.*, u.nombre_completo
             FROM expedientes e
             JOIN usuarios u ON e.id_paciente = u.id_usuario
             ORDER BY e.fecha_creacion DESC'
        );
        return $stmt->fetchAll();
    }

    public function getByPaciente(int $id_paciente): array|false
    {
        $stmt = $this->conn->prepare(
            'SELECT e.*, u.nombre_completo
             FROM expedientes e
             JOIN usuarios u ON e.id_paciente = u.id_usuario
             WHERE e.id_paciente = ?'
        );
        $stmt->execute([$id_paciente]);
        return $stmt->fetch();
    }

// Logica CRUD aqui
    public function create(int $id_paciente, string $historial, string $condiciones, string $alergias, string $discapacidades, string $observaciones): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO expedientes (id_paciente, historial_medico, condiciones_medicas, alergias, discapacidades, observaciones)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([$id_paciente, $historial, $condiciones, $alergias, $discapacidades, $observaciones]);
    }

    public function getById(int $id_expediente): array|false
    {
        $stmt = $this->conn->prepare(
            'SELECT e.*, u.nombre_completo
             FROM expedientes e
             JOIN usuarios u ON e.id_paciente = u.id_usuario
             WHERE e.id_expediente = ?'
        );
        $stmt->execute([$id_expediente]);
        return $stmt->fetch();
    }

    public function update(int $id_expediente, string $historial, string $condiciones, string $alergias, string $discapacidades, string $observaciones): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE expedientes
             SET historial_medico = ?, condiciones_medicas = ?, alergias = ?, discapacidades = ?, observaciones = ?
             WHERE id_expediente = ?'
        );
        return $stmt->execute([$historial, $condiciones, $alergias, $discapacidades, $observaciones, $id_expediente]);
    }

    public function delete(int $id_expediente): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM expedientes WHERE id_expediente = ?');
        return $stmt->execute([$id_expediente]);
    }
}