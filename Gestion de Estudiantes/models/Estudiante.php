<?php
// /models/Estudiante.php

class Estudiante {
    // Objeto PDO para la conexión a la base de datos
    private $pdo;

    // Constructor de la clase que recibe el objeto PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obtener todos los estudiantes
    public function obtenerTodos() {
        // Prepara la consulta SQL para seleccionar todos los estudiantes
        $stmt = $this->pdo->prepare("SELECT * FROM Estudiante");
        
        // Ejecuta la consulta
        $stmt->execute();
        
        // Devuelve todos los resultados de la consulta como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo estudiante
    public function crear($nombre, $apellido, $email, $edad) {
        // Prepara la consulta SQL para insertar un nuevo estudiante
        $stmt = $this->pdo->prepare("INSERT INTO Estudiante (nombre, apellido, email, edad) VALUES (:nombre, :apellido, :email, :edad)");
        
        // Ejecuta la consulta con los datos proporcionados
        return $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':email' => $email,
            ':edad' => $edad
        ]);
    }

    // Método para obtener un estudiante por su ID
    public function obtenerPorId($id) {
        // Prepara la consulta SQL para seleccionar un estudiante específico por su ID
        $stmt = $this->pdo->prepare("SELECT * FROM Estudiante WHERE id = :id");
        
        // Ejecuta la consulta con el ID proporcionado
        $stmt->execute([':id' => $id]);
        
        // Devuelve el resultado de la consulta como un array asociativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar la información de un estudiante
    public function actualizar($id, $nombre, $apellido, $email, $edad) {
        // Prepara la consulta SQL para actualizar la información del estudiante
        $stmt = $this->pdo->prepare("UPDATE Estudiante SET nombre = :nombre, apellido = :apellido, email = :email, edad = :edad WHERE id = :id");
        
        // Ejecuta la consulta con los datos proporcionados
        return $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':email' => $email,
            ':edad' => $edad,
            ':id' => $id
        ]);
    }

    // Método para eliminar un estudiante por su ID
    public function eliminar($id) {
        // Prepara la consulta SQL para eliminar un estudiante específico por su ID
        $stmt = $this->pdo->prepare("DELETE FROM Estudiante WHERE id = :id");
        
        // Ejecuta la consulta con el ID proporcionado
        return $stmt->execute([':id' => $id]);
    }
}
?>
