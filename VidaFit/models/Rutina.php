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

    // Eliminar una rutina
    public function delete(int $id_rutina): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM rutinas WHERE id_rutina = ?');
        return $stmt->execute([$id_rutina]);
    }
}