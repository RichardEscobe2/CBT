<?php

    // Iniciamos la sesion y incluimos el archivo de la conexion ala BD
session_start();
include("conexion.php");




// Aqui para iniciar sesion se va basar en el campo de la matricula, ese sera el identificador para iniciar sesion
// No debe haber matriculas duplicadas
$_SESSION['matricula'] = $matricula;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Aqui le decimos que los datos que el usuario nos dio en el formulario, que vienen con el metodo POST, las vamos a gguardar en sus respectivas nuevas variables
            $matricula = trim($_POST['matricula']);
            $contrasena = trim($_POST['contrasena']);
            // Verifica que los campos no esten vacios, si estan vacios va a mostrar un mensaje de alerta, y no va a dejar que pase si hay algun dato vacio
            // Se puede contar como una medida de seguridad
            if (empty($matricula) || empty($contrasena)) {
                echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
                exit();
            }
            // Encriptar contraseña con MD5 para comparación
            $contrasena_md5 = md5($contrasena);

            // Consulta SQL segura con prepared statements
            $sql = "SELECT * FROM alumnos WHERE matricula = ? AND e_contrasena = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error en la consulta: " . $conn->error);
            }

            $stmt->bind_param("is", $matricula, $contrasena_md5); // "i" para matrícula por que es INT, "s" para contraseña
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $usuario = $result->fetch_assoc();
                $_SESSION['matricula'] = $usuario['matricula'];
                $_SESSION["usuario"] = $usuario["matricula"];
                

                header("Location: menu.php"); // Redirige a la página principal después del login exitoso
                exit();
            } else {
                header("Location: index.php?error=Usuario%20o%20contraseña%20incorrectos.%20Inténtalo%20nuevamente.");
                exit();
            }

            $stmt->close();
}

$conn->close();
?>