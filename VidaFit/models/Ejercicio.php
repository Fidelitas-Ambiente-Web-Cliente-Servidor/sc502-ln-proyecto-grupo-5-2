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
}