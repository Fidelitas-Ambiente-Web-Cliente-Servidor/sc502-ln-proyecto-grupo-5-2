<?php
class PlanNutricional
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query(
            'SELECT * FROM planes_nutricionales ORDER BY fecha_inicio DESC'
        );
        return $stmt->fetchAll();
    }

    public function create(int $id_profesional, int $id_paciente, int $calorias, string $recomendaciones, string $fecha_inicio, ?string $fecha_fin): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO planes_nutricionales (id_profesional, id_paciente, calorias_diarias, recomendaciones, fecha_inicio, fecha_fin)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([$id_profesional, $id_paciente, $calorias, $recomendaciones, $fecha_inicio, $fecha_fin]);
    }

    public function delete(int $id_plan): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM planes_nutricionales WHERE id_plan = ?');
        return $stmt->execute([$id_plan]);
    }
}