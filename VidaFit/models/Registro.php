<?php

class Registro
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Obtiene todos los registros de progreso de un paciente
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

    // Obtiene registro mas reciente
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

    // Inserta informacion de progreso
    public function create(
        int $id_paciente,
        float $peso_kg,
        float $altura_m,
        float $imc,
        float $peso_ideal,
        string $estado_nutricional,
        ?string $medidas_corporales,
        ?string $observaciones_paciente,
        string $fecha_registro

    ): int {

        $stmt = $this->conn->prepare(
            'INSERT INTO registro_progreso
            (id_paciente, peso_kg, altura_m, imc, peso_ideal, estado_nutricional, medidas_corporales, observaciones_paciente, fecha_registro)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $id_paciente,
            $peso_kg,
            $altura_m,
            $imc,
            $peso_ideal,
            $estado_nutricional,
            $medidas_corporales,
            $observaciones_paciente,
            $fecha_registro
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function updateMedidas(int $id_progreso, string $medidas_corporales): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE registro_progreso SET medidas_corporales = ? WHERE id_progreso = ?'
        );
        return $stmt->execute([$medidas_corporales, $id_progreso]);
    }
}