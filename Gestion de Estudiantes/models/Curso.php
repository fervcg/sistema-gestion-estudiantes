<?php
// /models/Curso.php

class Curso {
    // Objeto PDO para la conexión a la base de datos
    private $pdo;

    // Constructor de la clase que recibe el objeto PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obtener todos los cursos
    public function obtenerTodos() {
        // Prepara la consulta SQL para seleccionar todos los cursos
        $stmt = $this->pdo->prepare("SELECT * FROM Curso");
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Devuelve todos los resultados de la consulta como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Puedes añadir más métodos según las necesidades del proyecto
    // Por ejemplo: agregarCurso(), obtenerCursoPorId(), actualizarCurso(), eliminarCurso(), etc.
}
?>
