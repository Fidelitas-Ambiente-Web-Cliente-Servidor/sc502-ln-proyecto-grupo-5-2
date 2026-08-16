<?php
class DetalleRutina
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function getByRutina(int $id_rutina): array
    {
        $stmt = $this->conn->prepare(
            'SELECT d.*, e.nombre_ejercicio, e.descripcion, e.video_url
             FROM detalle_rutina d
             JOIN ejercicios e ON d.id_ejercicio = e.id_ejercicio
             WHERE d.id_rutina = ?
             ORDER BY d.id_detalle ASC'
        );
        $stmt->execute([$id_rutina]);
        return $stmt->fetchAll();
    }

    public function create(
        int $id_rutina,
        int $id_ejercicio,
        int $series,
        int $repeticiones,
        ?string $dia_rutina = null,
        ?int $descanso_segundos = null,
        ?string $nivel_dificultad = null,
        ?int $calorias_por_sesion = null
    ): bool {
        $stmt = $this->conn->prepare(
            'INSERT INTO detalle_rutina
                (id_rutina, id_ejercicio, series, repeticiones, dia_rutina, descanso_segundos, nivel_dificultad, calorias_por_sesion)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $id_rutina,
            $id_ejercicio,
            $series,
            $repeticiones,
            ($dia_rutina !== null && $dia_rutina !== '') ? $dia_rutina : null,
            $descanso_segundos,
            ($nivel_dificultad !== null && $nivel_dificultad !== '') ? $nivel_dificultad : null,
            $calorias_por_sesion
        ]);
    }

    // Elimina un detalle
    public function delete(int $id_detalle): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM detalle_rutina WHERE id_detalle = ?');
        return $stmt->execute([$id_detalle]);
    }
}