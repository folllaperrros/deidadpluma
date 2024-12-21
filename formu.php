<?php
// Variables del formulario
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$materia = $_POST['materia'];
$telefono = $_POST['telefono'];

// Configuración de la base de datos
$host = "localhost";       // Host de la base de datos
$dbusername = "root";      // Usuario de la base de datos
$dbpassword = "";          // Contraseña de la base de datos
$dbname = "estudiante"; // Nombre de la base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    // Consulta para verificar si el número de teléfono ya está registrado
    $SELECT = "SELECT telefono FROM usuario WHERE telefono = ? LIMIT 1";
    // Consulta para insertar un nuevo registro
    $INSERT = "INSERT INTO usuario (nombre, password, genero, email, materia, telefono) VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar la consulta SELECT
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;

    if ($num_rows == 0) {
        // Cerrar el statement SELECT
        $stmt->close();

        // Preparar la consulta INSERT
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssssss", $nombre, $password, $genero, $email, $materia, $telefono);
        $stmt->execute();

        echo "Registro completado.";
    } else {
        echo "El número de teléfono ya está registrado.";
    }

    // Cerrar el statement y la conexión
    $stmt->close();
    $conn->close();
}
?>
