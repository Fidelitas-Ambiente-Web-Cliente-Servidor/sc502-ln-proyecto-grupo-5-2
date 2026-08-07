<?php
class DetalleRutina
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Obtiene todos los ejercicios de una rutina especifica
    public function getByRutina(int $id_rutina): array
    {
        $stmt = $this->conn->prepare(
            'SELECT d.*, e.nombre_ejercicio, e.descripcion
             FROM detalle_rutina d
             JOIN ejercicios e ON d.id_ejercicio = e.id_ejercicio
             WHERE d.id_rutina = ?
             ORDER BY d.id_detalle ASC'
        );
        $stmt->execute([$id_rutina]);
        return $stmt->fetchAll();
    }

    // Agrega un ejercicio a una rutina
    public function create(int $id_rutina, int $id_ejercicio, int $series, int $repeticiones): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO detalle_rutina (id_rutina, id_ejercicio, series, repeticiones)
             VALUES (?, ?, ?, ?)'
        );
        return $stmt->execute([$id_rutina, $id_ejercicio, $series, $repeticiones]);
    }

    // Elimina un detalle
    public function delete(int $id_detalle): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM detalle_rutina WHERE id_detalle = ?');
        return $stmt->execute([$id_detalle]);
    }
}