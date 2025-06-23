<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();}

// Configurar tiempo de inactividad (10 minutos = 600 segundos)
$inactividad = 600;

if (isset($_SESSION["ultimo_acceso"])) {
    $tiempo_inactivo = time() - $_SESSION["ultimo_acceso"];
    if ($tiempo_inactivo > $inactividad) {
        session_unset(); // Limpia variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: index.php?expirada=1"); 
        exit();
    }
}

// Actualizar el tiempo de acceso
$_SESSION["ultimo_acceso"] = time();

// Conexión a la base de datos
$host = "localhost";
$user = "root"; // Usuario de MySQL (por defecto es 'root')
$password = ""; // Contraseña de MySQL (déjala vacía si usas XAMPP)
$dbname = "esuela"; // Reemplaza con el nombre de tu BD

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
