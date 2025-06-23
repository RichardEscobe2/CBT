<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $matricula = $_POST['matricula'];

    // Obtener el resto de los datos del formulario
    $alumno = $_POST['alumno'];
    $semestre = $_POST['semestre'];
    $carrera = $_POST['carrera'];
    $competencia = $_POST['competencia'];
    $encargado = $_POST['encargado'];
    $dependencia = $_POST['dependencia'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_termino = $_POST['fecha_termino'];
    $horario = $_POST['horario'];
    $nivel = $_POST['nivel'];
    $actividades = $_POST['actividades'];
    $dias_asistencia = isset($_POST['dias_asistencia']) ? $_POST['dias_asistencia'] : '';


    if (
        empty($fecha) ||  empty($matricula) || empty($alumno) || empty($semestre) || empty($carrera) ||
        empty($competencia) || empty($encargado) || empty($dependencia) || empty($fecha_inicio) ||
        empty($fecha_termino) || empty($horario) || empty($nivel) || empty($actividades)|| empty($dias_asistencia)
    ) {
        echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
        exit();
    }
     
    // Validar que la fecha de inicio sea anterior a la fecha de fin
    if ($fecha_inicio > $fecha_termino) {
        echo "<script>alert('La fecha de inicio no puede ser posterior a la fecha de finalización.'); window.history.back();</script>";
        exit();
    }

    $sql = "REPLACE INTO term_compe_gastro 
    (fecha, matricula, alumno, semestre, carrera, competencia, encargado, dependencia, fecha_inicio, fecha_termino, horario, nivel, actividades, `dias_asistencia`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssss", $fecha, $matricula, $alumno, $semestre, $carrera, $competencia, $encargado, $dependencia, $fecha_inicio, $fecha_termino, $horario, $nivel, $actividades, $dias_asistencia);

if ($stmt->execute()) {
    echo "<script>alert('Datos guardados con éxito');</script>";
    sleep(3);
    header("Location: ../generar_pdf_practicas.php?alumno=" . urlencode($alumno));
    exit();
} else {
    echo "<script>alert('Error al guardar los datos'); window.location.href='../menu.php';</script>";
}

$stmt->close();
$conn->close();
}
?>