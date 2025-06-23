<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la fecha de registro
    $fecha = date("Y-m-d"); // Fecha actual

    // Obtener los datos del formulario
    $nombre_encargado = $_POST['nombre_encargado'];
    $cargo = $_POST['cargo'];
    $dependencia = $_POST['dependencia'];
    $nombre_alumno = $_POST['nombre_alumno'];
    $semestre = $_POST['semestre'];
    $carrera = $_POST['carrera'];
    $dia1 = $_POST['dia1'];
    $dia2 = $_POST['dia2'];
    $ay = $_POST['ay'];
    $hr1 = $_POST['hr1'];
    $hr2 = $_POST['hr2'];
    if (!isset($_SESSION['matricula']) || empty($_SESSION['matricula'])) {
        echo "<script>alert('Error: No se encontró la matrícula en sesión. Inicia sesión nuevamente.'); window.location.href='../login.php';</script>";
        exit();
    }
    
    $matricula = $_SESSION['matricula'];
    

   

    // Consulta SQL para insertar los datos en la base de datos
    $sql = "REPLACE INTO carta_presentacion (fecha, nombre_encargado, cargo, dependencia, nombre_alumno, semestre, carrera, matricula, dia1, dia2, ay, hr1, hr2) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $fecha, $nombre_encargado, $cargo, $dependencia, $nombre_alumno, $semestre, $carrera, $matricula, $dia1, $dia2, $ay, $hr1, $hr2);

    

    if ($stmt->execute()) {
        echo "<script>alert('Datos guardados con éxito');</script>";
    
        // Esperar 3 segundos antes de redirigir
        sleep(3);
    
        // Obtener el ID de la carta recién insertada
        $id_carta = $stmt->insert_id;  
    
        // Redirigir directamente a la generación del PDF
        header("Location: ../generar_pdf_carta.php?nombre_alumno=" . urlencode($nombre_alumno));
        exit();
    } else {
        echo "<script>alert('Error al guardar los datos'); window.location.href='../menu.php';</script>";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>