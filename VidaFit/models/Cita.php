<?php

class Cita
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Cita mas proxima de un paciente
    public function getProximaByPaciente(int $id_paciente): array|false
    {
        $stmt = $this->conn->prepare(
            'SELECT c.*, u.nombre_completo AS nombre_profesional
             FROM citas c
             INNER JOIN usuarios u ON u.id_usuario = c.id_profesional
             WHERE c.id_paciente = ?
               AND c.estado = "Programada"
               AND (c.fecha > CURDATE() OR (c.fecha = CURDATE() AND c.hora >= CURTIME()))
             ORDER BY c.fecha ASC, c.hora ASC
             LIMIT 1'
        );

        $stmt->execute([$id_paciente]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Todas las citas de un paciente
    public function getAllByPaciente(int $id_paciente): array
    {
        $stmt = $this->conn->prepare(
            'SELECT c.*, u.nombre_completo AS nombre_profesional
             FROM citas c
             INNER JOIN usuarios u ON u.id_usuario = c.id_profesional
             WHERE c.id_paciente = ?
             ORDER BY c.fecha DESC, c.hora DESC'
        );

        $stmt->execute([$id_paciente]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Todas las citas agendadas por un profesional
    public function getAllByProfesional(int $id_profesional): array
    {
        $stmt = $this->conn->prepare(
            'SELECT c.*, u.nombre_completo AS nombre_paciente
             FROM citas c
             INNER JOIN usuarios u ON u.id_usuario = c.id_paciente
             WHERE c.id_profesional = ?
             ORDER BY c.fecha DESC, c.hora DESC'
        );

        $stmt->execute([$id_profesional]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crea una cita nueva
    public function create(
        int $id_profesional,
        int $id_paciente,
        string $fecha,
        string $hora,
        ?string $motivo
    ): int {

        $stmt = $this->conn->prepare(
            'INSERT INTO citas (id_profesional, id_paciente, fecha, hora, motivo)
             VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $id_profesional,
            $id_paciente,
            $fecha,
            $hora,
            $motivo
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Cambia el estado de una cita (Programada, Completada, Cancelada)
    public function cambiarEstado(int $id_cita, string $estado): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE citas SET estado = ? WHERE id_cita = ?'
        );

        return $stmt->execute([$estado, $id_cita]);
    }

    // Obtiene una cita y valida permisos en dado caso de que el usuario quiera cancelarla.
    public function getById(int $id_cita): array|false
    {
        $stmt = $this->conn->prepare(
            'SELECT * FROM citas WHERE id_cita = ?'
        );

        $stmt->execute([$id_cita]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Profesionales disponibles 
    public function getProfesionalesDisponibles(): array
    {
        $stmt = $this->conn->prepare(
            'SELECT id_usuario, nombre_completo
             FROM usuarios
             WHERE id_rol = 2
             ORDER BY nombre_completo ASC'
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}