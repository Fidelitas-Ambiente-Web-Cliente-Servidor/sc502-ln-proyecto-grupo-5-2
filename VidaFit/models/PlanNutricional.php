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
            'SELECT p.*, u.nombre_completo
             FROM planes_nutricionales p
             JOIN usuarios u ON p.id_paciente = u.id_usuario
             ORDER BY p.fecha_inicio DESC'
        );
        return $stmt->fetchAll();
    }

    // Trae el plan mas reciente de un paciente
    public function getUltimoPorPaciente(int $id_paciente): ?array
    {
        $stmt = $this->conn->prepare(
            'SELECT * FROM planes_nutricionales
             WHERE id_paciente = ?
             ORDER BY fecha_inicio DESC, id_plan DESC
             LIMIT 1'
        );
        $stmt->execute([$id_paciente]);
        $plan = $stmt->fetch();
        return $plan !== false ? $plan : null;
    }

    public function create(
        int $id_profesional,
        int $id_paciente,
        int $calorias,
        string $recomendaciones,
        string $fecha_inicio,
        ?string $fecha_fin,
        ?int $proteinas_g = null,
        ?int $carbohidratos_g = null,
        ?int $grasas_g = null,
        ?float $agua_litros = null
    ): int {
        $stmt = $this->conn->prepare(
            'INSERT INTO planes_nutricionales
                (id_profesional, id_paciente, calorias_diarias, proteinas_g, carbohidratos_g, grasas_g, agua_litros, recomendaciones, fecha_inicio, fecha_fin)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $id_profesional,
            $id_paciente,
            $calorias,
            $proteinas_g,
            $carbohidratos_g,
            $grasas_g,
            $agua_litros,
            $recomendaciones,
            $fecha_inicio,
            $fecha_fin
        ]);
        return (int) $this->conn->lastInsertId();
    }

    public function delete(int $id_plan): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM planes_nutricionales WHERE id_plan = ?');
        return $stmt->execute([$id_plan]);
    }
}