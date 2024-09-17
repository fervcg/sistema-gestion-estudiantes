<?php 
// Archivo de conexión a la base de datos
include_once 'db/conexion.php';

// Array para almacenar los cursos
$cursos = [];

// Intenta consultar los cursos desde la base de datos
try {
    // Prepara y ejecuta la consulta para seleccionar ID y nombre del curso
    $query = $pdo->query("SELECT id, nombre_curso FROM Curso"); // Asegúrate de que el nombre de la tabla sea correcto
    // Obtiene todos los cursos en un array asociativo
    $cursos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En caso de error en la consulta, guarda el mensaje de error
    $error = 'Error al consultar los cursos: ' . htmlspecialchars($e->getMessage());
}

// Verificar si la conexión a la base de datos fue exitosa
if (!$pdo) {
    $error = 'No se pudo establecer la conexión a la base de datos.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="container">
        <!-- Barra de navegación lateral -->
        <aside class="sidebar">
            <h2>Opciones</h2>
            <ul>
                <!-- Enlaces para mostrar diferentes secciones -->
                <li><a href="#" onclick="mostrarSeccion('lista-alumnos')">Lista de Alumnos</a></li>
                <li><a href="#" onclick="mostrarSeccion('crear-alumno')">Crear Alumno</a></li>
                <li><a href="#" onclick="mostrarSeccion('actualizar-alumno')">Actualizar Alumno</a></li>
                <li><a href="#" onclick="mostrarSeccion('eliminar-alumno')">Eliminar Alumno</a></li>
                <li><a href="#" onclick="mostrarSeccion('estudiantes-por-curso')">Estudiantes por Curso</a></li>
                <li><a href="#" onclick="mostrarSeccion('cursos-estudiante')">Cursos de un Estudiante</a></li>
            </ul>
        </aside>

        <!-- Panel principal -->
        <main class="content">
            <!-- Sección para mostrar la lista de alumnos -->
            <div id="lista-alumnos" class="seccion" style="display: none;">
                <h2>Lista de Alumnos</h2>
                <div id="resultado-lista-alumnos"></div>
            </div>

            <!-- Sección para crear un nuevo alumno -->
            <div id="crear-alumno" class="seccion" style="display: none;">
                <h2>Crear Alumno</h2>
                <form id="form-crear-alumno">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" required>

                    <button type="submit">Crear Alumno</button>
                </form>
            </div>

            <!-- Sección para actualizar un alumno existente -->
            <div id="actualizar-alumno" class="seccion" style="display: none;">
                <h2>Actualizar Alumno</h2>
                <form id="form-actualizar-alumno">
                    <label for="id-actualizar">ID del Alumno:</label>
                    <input type="number" id="id-actualizar" name="id-actualizar" required>

                    <label for="nombre-actualizar">Nombre:</label>
                    <input type="text" id="nombre-actualizar" name="nombre-actualizar">

                    <label for="apellido-actualizar">Apellido:</label>
                    <input type="text" id="apellido-actualizar" name="apellido-actualizar">

                    <label for="email-actualizar">Email:</label>
                    <input type="email" id="email-actualizar" name="email-actualizar">

                    <label for="edad-actualizar">Edad:</label>
                    <input type="number" id="edad-actualizar" name="edad-actualizar">

                    <button type="submit">Actualizar Alumno</button>
                </form>
            </div>

            <!-- Sección para mostrar estudiantes por curso -->
            <div id="estudiantes-por-curso" class="seccion" style="display: none;">
                <h2>Estudiantes por Curso</h2>

                <h3>Cursos Disponibles</h3>
                <div id="lista-cursos">
                    <ul>
                    <?php
                    // Muestra la lista de cursos disponibles
                    if (!empty($cursos)) {
                        foreach ($cursos as $curso) {
                            echo "<li>ID: " . htmlspecialchars($curso['id']) . ", Curso: " . htmlspecialchars($curso['nombre_curso']) . "</li>";
                        }
                    } else {
                        echo '<li>No hay cursos disponibles.</li>';
                    }
                    ?>
                    </ul>
                </div>

                <form id="form-estudiantes-curso">
                    <label for="curso-id">Selecciona el Curso:</label>
                    <select id="curso-id" name="curso-id" required>
                        <option value="">Seleccione un curso</option>
                        <?php
                        // Llena el selector con los cursos disponibles
                        if (!empty($cursos)) {
                            foreach ($cursos as $curso) {
                                echo "<option value='" . htmlspecialchars($curso['id']) . "'>" . htmlspecialchars($curso['nombre_curso']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <button type="submit">Buscar Estudiantes</button>
                </form>
                <div id="resultado-estudiantes-curso"></div>
            </div>

            <!-- Sección para eliminar un alumno -->
            <div id="eliminar-alumno" class="seccion" style="display: none;">
                <h2>Eliminar Alumno</h2>
                <form id="form-eliminar-alumno">
                    <label for="id-eliminar">ID del Alumno:</label>
                    <input type="number" id="id-eliminar" name="id-eliminar" required>
                    <button type="submit">Eliminar Alumno</button>
                </form>
            </div>

            <!-- Sección para mostrar cursos de un estudiante -->
            <div id="cursos-estudiante" class="seccion" style="display: none;">
                <h2>Cursos de un Estudiante</h2>
                <form id="form-cursos-estudiante">
                    <label for="estudiante-id">ID del Estudiante:</label>
                    <input type="number" id="estudiante-id" name="estudiante-id" required>
                    <button type="submit">Buscar Cursos</button>
                </form>
                <div id="resultado-cursos-estudiante"></div>
            </div>
        </main>
    </div>

    <!-- Incluye el script JavaScript para manejar la interacción -->
    <script src="../js/script.js"></script>
</body>
</html>
