<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../styles2.css" rel="stylesheet">
    <title>Prácticas y Estadías</title>


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
<body>
<nav class="navbar navbar-light bg-white shadow-sm px-4 d-flex justify-content-between align-items-center">
<img src="logos.png" alt="Logo" height="40">
    
    <img src="logo.png" alt="Logos" height="65">
</nav>

<div class="container mt-5 d-flex justify-content-center">
    <div class="card p-4 shadow-lg rounded-4" style="max-width: 700px; width: 100%;">
        <h3 class="text-center mb-3">Prácticas y Estadías</h3>
        <form action="guardar_practicas.php" method="POST">
            
            <h5 class="mb-3">Datos del Alumno</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Trámite</label>
                    <select class="form-control" name="tramite" required>
                        <option value="Prácticas">Prácticas de ejecución</option>
                        <option value="Estadías">Estadías</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Carrera</label>
                    <input type="text" class="form-control" name="carrera" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Alumno</label>
                    <input type="text" class="form-control" name="nombre_alumno" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Entidad de Nacimiento</label>
                    <input type="text" class="form-control" name="entidad_nacimiento" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">CURP</label>
                    <input type="text" class="form-control" name="curp" pattern=".{16,19}" required>
                    <small class="text-muted">Debe contener entre 16 y 19 caracteres</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Grado</label>
                    <input type="text" class="form-control" name="grado" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Grupo</label>
                    <input type="text" class="form-control" name="grupo" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Matrícula</label>
                    <input type="text" class="form-control" name="matricula" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Número de Seguro Social</label>
                    <input type="text" class="form-control" name="numero_seguro" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Promedio</label>
                    <input type="text" class="form-control" name="promedio" required>
                </div>
            </div>

            <!-- Nuevos campos agregados -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo_electronico" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono Celular</label>
                    <input type="text" class="form-control" name="telefono_celular" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Domicilio</label>
                    <input type="text" class="form-control" name="domicilio" required>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Datos de la Empresa</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Empresa</label>
                    <input type="text" class="form-control" name="empresa" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">RFC o CCT</label>
                    <input type="text" class="form-control" name="rfc_cct" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Funcionario Responsable</label>
                    <input type="text" class="form-control" name="funcionario_responsable" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Cargo</label>
                    <input type="text" class="form-control" name="cargo" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono del Funcionario</label>
                    <input type="text" class="form-control" name="telefono_funcionario" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Actividades a Desarrollar</label>
                <textarea class="form-control" name="actividades" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Días que Asiste</label>
                    <input type="text" class="form-control" name="dias_asiste" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Horario</label>
                    <input type="text" class="form-control" name="horario" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" name="fecha_inicio" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha de Término</label>
                    <input type="date" class="form-control" name="fecha_termino" required>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
