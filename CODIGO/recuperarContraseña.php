
<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "incidencias_tic";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $statusMsg = "Correo electrónico no válido.";
        $statusMsgType = "alert-danger";
    } else {
        // Escapar caracteres especiales para prevenir inyecciones SQL
        $email = $conn->real_escape_string($email);
        
        // Ejecutar la consulta
        $sql = "SELECT id FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // El correo existe en la base de datos
            $statusMsg = "Correo encontrado. Se ha enviado un enlace de recuperación.";
            $statusMsgType = "alert-success";
            // Aquí puedes añadir el código para enviar el correo de recuperación
        } else {
            // El correo no existe en la base de datos
            $statusMsg = "El correo electrónico no está registrado.";
            $statusMsgType = "alert-danger";
        }
    }
}

$conn->close();
?>