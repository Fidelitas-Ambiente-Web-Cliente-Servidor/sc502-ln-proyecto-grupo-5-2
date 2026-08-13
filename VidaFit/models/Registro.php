<?php

class Registro
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Obtener todos los registros de progreso de un paciente
    public function getAll(int $id_paciente): array
    {
        $stmt = $this->conn->prepare(
            'SELECT * 
             FROM registro_progreso 
             WHERE id_paciente = ?
             ORDER BY fecha_registro DESC'
        );

        $stmt->execute([$id_paciente]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Obtener registro mas reciente
public function getLatest(int $id_paciente): array|false
{
    $stmt = $this->conn->prepare(
        'SELECT *
         FROM registro_progreso
         WHERE id_paciente = ?
         ORDER BY fecha_registro DESC
         LIMIT 1'
    );

    $stmt->execute([$id_paciente]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Insertar información de progreso
    public function create(
        int $id_paciente,
        float $peso_kg,
        float $imc,
        float $peso_ideal,
        string $fecha_registro
        
    ): int {
        
        $stmt = $this->conn->prepare(
            'INSERT INTO registro_progreso 
            (id_paciente, peso_kg, imc, peso_ideal, fecha_registro)
            VALUES (?, ?, ?, ?,?)'
        );

        $stmt->execute([
            $id_paciente,
            $peso_kg,
            $imc,
            $peso_ideal,
            $fecha_registro
        ]);

        return (int) $this->conn->lastInsertId();
    }
}