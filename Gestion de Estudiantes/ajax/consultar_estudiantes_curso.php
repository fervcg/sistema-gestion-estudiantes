<?php
require '../db/conexion.php';

header('Content-Type: application/json');

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['curso_id'])) {
        $curso_id = $_POST['curso_id'];

        // Consulta SQL para obtener los estudiantes en un curso
        $sql = "SELECT e.id, e.nombre, e.apellido, e.email, e.edad 
                FROM Estudiante e 
                JOIN Estudiante_Curso ec ON e.id = ec.estudiante_id 
                WHERE ec.curso_id = :curso_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($estudiantes);
        } else {
            // Enviar una respuesta JSON vacía en caso de error
            echo json_encode([]);
        }
    } else {
        // Enviar una respuesta JSON vacía si falta el parámetro 'curso_id'
        echo json_encode([]);
    }
} else {
    // Enviar una respuesta JSON vacía si la solicitud no es POST
    echo json_encode([]);
}
?>
