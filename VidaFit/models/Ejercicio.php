<?php
class Ejercicio
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Obtiene todos los ejercicios del catalogo
    public function getAll(): array
    {
        $stmt = $this->conn->query('SELECT * FROM ejercicios ORDER BY nombre_ejercicio ASC');
        return $stmt->fetchAll();
    }

    // Agrega un ejercicio nuevo al catalogo
    public function create(string $nombre_ejercicio, ?string $descripcion): int
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO ejercicios (nombre_ejercicio, descripcion)
             VALUES (?, ?)'
        );
        $stmt->execute([$nombre_ejercicio, $descripcion]);
        return (int) $this->conn->lastInsertId();
    }
}