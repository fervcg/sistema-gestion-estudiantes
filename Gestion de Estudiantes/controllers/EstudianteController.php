<?php
// /controllers/EstudianteController.php

// Incluye el archivo de conexión a la base de datos
include_once '../db/conexion.php';

// Incluye el archivo del modelo Estudiante que contiene la lógica de negocio
include_once '../models/Estudiante.php';

// Crea una instancia de la clase Estudiante pasando el objeto PDO
$estudiante = new Estudiante($pdo);

// Obtiene el método de solicitud HTTP (GET, POST, PUT, DELETE)
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Lee los datos JSON de la solicitud y los decodifica en un array asociativo
$input = json_decode(file_get_contents('php://input'), true);

// Maneja la solicitud según el método HTTP
switch ($requestMethod) {
    // Maneja las solicitudes GET
    case 'GET':
        // Si se proporciona un ID, obtiene los datos del estudiante con ese ID
        if (isset($_GET['id'])) {
            $data = $estudiante->obtenerPorId($_GET['id']);
            echo json_encode($data);
        } else {
            // Si no se proporciona un ID, obtiene todos los estudiantes
            $data = $estudiante->obtenerTodos();
            echo json_encode($data);
        }
        break;
    
    // Maneja las solicitudes POST
    case 'POST':
        // Verifica si se han proporcionado los datos necesarios para crear un nuevo estudiante
        if (isset($input['nombre'], $input['apellido'], $input['email'], $input['edad'])) {
            // Llama al método de crear en el modelo Estudiante
            $success = $estudiante->crear($input['nombre'], $input['apellido'], $input['email'], $input['edad']);
            if ($success) {
                // Envía una respuesta JSON indicando éxito
                echo json_encode(["message" => "Alumno creado exitosamente."]);
            } else {
                // Envía una respuesta JSON indicando error
                echo json_encode(["message" => "Error al crear el alumno."]);
            }
        }
        break;
    
    // Maneja las solicitudes PUT
    case 'PUT':
        // Verifica si se han proporcionado los datos necesarios para actualizar un estudiante
        if (isset($input['id'], $input['nombre'], $input['apellido'], $input['email'], $input['edad'])) {
            // Llama al método de actualizar en el modelo Estudiante
            $success = $estudiante->actualizar($input['id'], $input['nombre'], $input['apellido'], $input['email'], $input['edad']);
            if ($success) {
                // Envía una respuesta JSON indicando éxito
                echo json_encode(["message" => "Alumno actualizado exitosamente."]);
            } else {
                // Envía una respuesta JSON indicando error
                echo json_encode(["message" => "Error al actualizar el alumno."]);
            }
        }
        break;
    
    // Maneja las solicitudes DELETE
    case 'DELETE':
        // Verifica si se ha proporcionado un ID para eliminar el estudiante
        if (isset($_GET['id'])) {
            // Llama al método de eliminar en el modelo Estudiante
            $success = $estudiante->eliminar($_GET['id']);
            if ($success) {
                // Envía una respuesta JSON indicando éxito
                echo json_encode(["message" => "Alumno eliminado exitosamente."]);
            } else {
                // Envía una respuesta JSON indicando error
                echo json_encode(["message" => "Error al eliminar el alumno."]);
            }
        }
        break;
    
    // Maneja métodos HTTP no permitidos
    default:
        // Envía una respuesta HTTP 405 Method Not Allowed
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
