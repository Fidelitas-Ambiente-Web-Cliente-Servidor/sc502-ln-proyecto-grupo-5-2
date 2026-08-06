<?php
class PlanComida
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function getByPlan(int $id_plan): array
    {
        $stmt = $this->conn->prepare(
            'SELECT * FROM plan_comidas WHERE id_plan = ? ORDER BY horario ASC'
        );
        $stmt->execute([$id_plan]);
        return $stmt->fetchAll();
    }

    public function create(int $id_plan, string $nombre_comida, ?string $horario, string $descripcion_alimentos): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO plan_comidas (id_plan, nombre_comida, horario, descripcion_alimentos)
             VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([$id_plan, $nombre_comida, $horario, $descripcion_alimentos]);
    }

    public function delete(int $id_comida): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM plan_comidas WHERE id_comida = ?');
        return $stmt->execute([$id_comida]);
    }
}