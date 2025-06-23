<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../styles2.css" rel="stylesheet">
    <title>Carta de Presentación</title>
    <style>
        /* Aseguramos que el formulario siempre esté centrado */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Asegura que se mantenga centrado incluso en pantallas grandes */
        }

    
      
        
    
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-light bg-white shadow-sm px-4 d-flex justify-content-between align-items-center">
<img src="logos.png" alt="Logo" height="40">



    <!-- Logo derecho -->
    <img src="logo.png" alt="Logos" height="65">
</nav>

<div class="form-container">
    <div class="card p-4 shadow-lg rounded-4">
        <h3 class="text-center mb-3">Carta de Presentación</h3>
        <form action="guardar_carta.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" value="<?= date('Y-m-d'); ?>" readonly>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Encargado</label>
                    <input type="text" class="form-control" name="nombre_encargado" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cargo del Encargado</label>
                    <input type="text" class="form-control" name="cargo" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Dependencia</label>
                <input type="text" class="form-control" name="dependencia" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Alumno</label>
                    <input type="text" class="form-control" name="nombre_alumno" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Semestre</label>
                    <input type="text" class="form-control" name="semestre" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Carrera</label>
                <input type="text" class="form-control" name="carrera" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Horario</label>
                <input type="text" class="form-control" name="horario" id="horario" 
                    placeholder="Ejemplo Lunes-Viernes 08:05-10:10" required
                    pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]+-[A-Za-zÁÉÍÓÚáéíóúÑñ]+ \d{2}:\d{2}-\d{2}:\d{2}$">
                <small class="text-danger d-none" id="errorHorario">Formato incorrecto. Use: Lunes-Viernes 00:00-00:00</small>
            </div>

            <div class="mb-3 d-flex justify-content-center">
    <button type="submit" class="btn btncito w-100">Guardar</button>
</div>

<!-- Botones "Volver" y "Cerrar Sesión" en una fila debajo, cada uno al 50% -->
<div class="mb-3 d-flex justify-content-center gap-2">
    <a href="../menu.php" class="btn btnvolver w-50">Volver</a>
    <a href="../logout.php" class="btn btn-danger w-50">Cerrar Sesión</a>
</div>

        </form>
    </div>
</div>

<script>
document.querySelector("form").addEventListener("submit", function(event) {
    let horarioInput = document.getElementById("horario");
    let errorMsg = document.getElementById("errorHorario");
    let regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]+-[A-Za-zÁÉÍÓÚáéíóúÑñ]+ \d{2}:\d{2}-\d{2}:\d{2}$/;

    if (!regex.test(horarioInput.value)) {
        event.preventDefault(); // Evita el envío
        errorMsg.classList.remove("d-none"); // Muestra el mensaje de error
    } else {
        errorMsg.classList.add("d-none"); // Oculta el mensaje si es correcto
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
