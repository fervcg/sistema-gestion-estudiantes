<?php
// /ajax/obtener_estudiante.php

// Establece el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

// Incluye el archivo de conexión a la base de datos para poder ejecutar consultas
include_once '../db/conexion.php';

// Verifica si el parámetro 'id' está presente en la solicitud GET
if (isset($_GET['id'])) {
    // Obtiene el valor del parámetro 'id' de la solicitud GET
    $id = $_GET['id'];

    // Prepara una consulta SQL para seleccionar todos los datos del estudiante con el id proporcionado
    $stmt = $pdo->prepare("SELECT * FROM Estudiante WHERE id = :id");
    
    // Ejecuta la consulta con el parámetro id
    $stmt->execute([':id' => $id]);
    
    // Recupera el resultado de la consulta como un array asociativo
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si se encontró un estudiante con el id proporcionado
    if ($estudiante) {
        // Devuelve los datos del estudiante en formato JSON
        echo json_encode($estudiante);
    } else {
        // Devuelve un mensaje de error en formato JSON si el estudiante no fue encontrado
        echo json_encode(["error" => "Alumno no encontrado."]);
    }
} else {
    // Devuelve un mensaje de error en formato JSON si el id no fue proporcionado en la solicitud
    echo json_encode(["error" => "ID del alumno no proporcionado."]);
}
?>
