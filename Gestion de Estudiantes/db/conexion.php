<?php
// Configuración de la base de datos

// Define el DSN (Data Source Name) para la conexión a la base de datos
// En este caso, se está utilizando MySQL con la base de datos 'gestion_estudiantes'
$dsn = 'mysql:host=localhost;dbname=gestion_estudiantes';

// Define el nombre de usuario para la conexión a la base de datos
$username = 'root';

// Define la contraseña para la conexión a la base de datos
$password = '1234';

try {
    // Crea una nueva instancia de PDO para la conexión a la base de datos
    $pdo = new PDO($dsn, $username, $password);

    // Configura PDO para que lance excepciones en caso de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si ocurre una excepción (error) al intentar conectar a la base de datos,
    // muestra un mensaje de error y detiene la ejecución del script
    echo 'Error de conexión: ' . htmlspecialchars($e->getMessage());
    exit;
}
?>
