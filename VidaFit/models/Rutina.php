<?php
class Rutina
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Obtiene todas las rutinas
    public function getAll(): array
    {
        $stmt = $this->conn->query(
            'SELECT r.*, u.nombre_completo
             FROM rutinas r
             JOIN usuarios u ON r.id_paciente = u.id_usuario
             ORDER BY r.id_rutina DESC'
        );
        return $stmt->fetchAll();
    }

    // Rutinas asignadas a un paciente especifico (la mas reciente es la que usa primero)
    public function getByPaciente(int $id_paciente): array
    {
        $stmt = $this->conn->prepare(
            'SELECT r.*, u.nombre_completo AS nombre_profesional
             FROM rutinas r
             JOIN usuarios u ON r.id_profesional = u.id_usuario
             WHERE r.id_paciente = ?
             ORDER BY r.id_rutina DESC'
        );
        $stmt->execute([$id_paciente]);
        return $stmt->fetchAll();
    }

    // Rutinas creadas por un profesional
    public function getByProfesional(int $id_profesional): array
    {
        $stmt = $this->conn->prepare(
            'SELECT r.*, u.nombre_completo AS nombre_paciente
             FROM rutinas r
             JOIN usuarios u ON r.id_paciente = u.id_usuario
             WHERE r.id_profesional = ?
             ORDER BY r.id_rutina DESC'
        );
        $stmt->execute([$id_profesional]);
        return $stmt->fetchAll();
    }

    // Crea una nueva rutina
    public function create(int $id_profesional, int $id_paciente, int $frecuencia, ?int $duracion): int
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO rutinas (id_profesional, id_paciente, frecuencia_semanal, duracion_total)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$id_profesional, $id_paciente, $frecuencia, $duracion]);
        return (int) $this->conn->lastInsertId();
    }

    // Elimina una rutina
    public function delete(int $id_rutina): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM rutinas WHERE id_rutina = ?');
        return $stmt->execute([$id_rutina]);
    }
}