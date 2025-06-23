<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener datos del formulario
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre'];
    $carrera = $_POST['carrera'];
    $matricula = $_POST['matricula'];
    $encargado = $_POST['encargado'];
    $dependencia = $_POST['dependencia'];
    $desempeno = $_POST['desempeno'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_salida = $_POST['hora_salida'];

    // Validación de campos vacíos
    if (
        empty($fecha) || empty($nombre) || empty($carrera) || empty($matricula) ||
        empty($encargado) || empty($dependencia) || empty($desempeno) ||
        empty($fecha_inicio) || empty($fecha_fin) || empty($hora_inicio) || empty($hora_salida)
    ) {
        echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
        exit();
    }

    // Validar que la fecha de inicio sea anterior a la fecha de fin
    if ($fecha_inicio > $fecha_fin) {
        echo "<script>alert('La fecha de inicio no puede ser posterior a la fecha de finalización.'); window.history.back();</script>";
        exit();
    }

    // Validar que la hora de entrada sea anterior a la hora de salida
    if ($hora_inicio >= $hora_salida) {
        echo "<script>alert('La hora de entrada debe ser menor a la hora de salida.'); window.history.back();</script>";
        exit();
    }

    // Guardar en la base de datos (tabla de ejemplo: constancia_termino_servicio)
    $sql = "REPLACE INTO constancia_termino_ss 
            (fecha, nombre, carrera, matricula, encargado, dependencia, desempeno, fecha_inicio, fecha_fin, hora_inicio, hora_salida)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $fecha, $nombre, $carrera, $matricula, $encargado, $dependencia, $desempeno, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_salida);

    
if ($stmt->execute()) {
    echo "<script>alert('Datos guardados con éxito');</script>";
    sleep(3);
    header("Location: ../generar_pdf_termino_ss.php?alumno=" . urlencode($alumno));
    exit();
} else {
    echo "<script>alert('Error al guardar los datos'); window.location.href='../menu.php';</script>";
}

$stmt->close();
$conn->close();
}
?>