<?php include("../conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tablas Escuela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
      <link href="../88.css" rel="stylesheet" /> <!-- Link a la hoja de estilos en CSS -->
</head>
<body>


<!-- Barra de Navegacion -->
  <nav class="navbar navbar-light bg-white shadow-sm px-4 fixed-top d-flex justify-content-between align-items-center">
    <img src="../sub/logos.png" alt="Logo Gubernamental" height="40" class="img-fluid logo logo-principal">
    <img src="../sub/logo.png" alt="Logo Educativo" height="65" class="img-fluid logo logo-secundario">
  </nav>
  <div style="height: 90px;"></div>





<div class="container mt-4">
    <h1 class="mb-4">Datos de la base de datos Escuela</h1>
    <h1 class="mb-4">Bienvenid@: </h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="text" name="matricula" class="form-control" placeholder="Buscar matrícula" value="<?= isset($_GET['matricula']) ? htmlspecialchars($_GET['matricula']) : '' ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Buscar</button>
        </div>
    </form>

    <?php $matricula = isset($_GET['matricula']) ? $conn->real_escape_string($_GET['matricula']) : null; ?>

    <ul class="nav nav-tabs" id="dbTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="alumnos-tab" data-bs-toggle="tab" data-bs-target="#alumnos" type="button" role="tab" aria-controls="alumnos" aria-selected="true">Administradores</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="carta-tab" data-bs-toggle="tab" data-bs-target="#carta" type="button" role="tab" aria-controls="carta" aria-selected="false">Carta Presentación</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="gastro-tab" data-bs-toggle="tab" data-bs-target="#gastro" type="button" role="tab" aria-controls="gastro" aria-selected="false">Carta Termino Competencias</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="constancia-tab" data-bs-toggle="tab" data-bs-target="#constancia" type="button" role="tab" aria-controls="constancia" aria-selected="false">Constancia SS</button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-3" id="dbTabsContent">
        <!-- Alumnos (no se filtra) -->
        <div class="tab-pane fade show active" id="alumnos" role="tabpanel" aria-labelledby="alumnos-tab">
            <?php
            $sql = "SELECT id, matricula, contrasena FROM alumnos";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                echo '<div class="table-responsive"><table class="table table-striped table-bordered">';
                echo '<thead class="table-dark"><tr><th>ID</th><th>Matrícula</th><th>Contraseña</th></tr></thead><tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['id']}</td><td>{$row['matricula']}</td><td>{$row['contrasena']}</td></tr>";
                }
                echo '</tbody></table></div>';
            } else {
                echo '<p>No hay registros en Alumnos.</p>';
            }
            ?>
        </div>

        <!-- Carta Presentación -->
        <div class="tab-pane fade" id="carta" role="tabpanel" aria-labelledby="carta-tab">
            <?php
            $sql = "SELECT * FROM carta_presentacion";
            if ($matricula) {
                $sql .= " WHERE matricula = '$matricula'";
            }
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                echo '<div class="table-responsive"><table class="table table-striped table-bordered table-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>ID</th><th>Fecha</th><th>Nombre Encargado</th><th>Cargo</th><th>Dependencia</th><th>Nombre Alumno</th><th>Semestre</th><th>Carrera</th><th>Matrícula</th><th>Día 1</th><th>AY</th><th>Día 2</th><th>Hr 1</th><th>Hr 2</th>';
                echo '</tr></thead><tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    foreach ($row as $value) echo '<td>' . htmlspecialchars($value) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<p>No hay registros en Carta Presentación.</p>';
            }
            ?>
        </div>

        <!-- Constancia de término SS -->
        <div class="tab-pane fade" id="constancia" role="tabpanel" aria-labelledby="constancia-tab">
            <?php
            $sql = "SELECT * FROM constancia_termino_ss";
            if ($matricula) {
                $sql .= " WHERE matricula = '$matricula'";
            }
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                echo '<div class="table-responsive"><table class="table table-striped table-bordered table-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>ID</th><th>Matrícula</th><th>Fecha</th><th>Nombre</th><th>Carrera</th><th>Encargado</th><th>Dependencia</th><th>Desempeño</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Hora Inicio</th><th>Hora Salida</th>';
                echo '</tr></thead><tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    foreach ($row as $value) echo '<td>' . htmlspecialchars($value) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<p>No hay registros en Constancia de término SS.</p>';
            }
            ?>
        </div>

        <!-- Competencias Gastro -->
        <div class="tab-pane fade" id="gastro" role="tabpanel" aria-labelledby="gastro-tab">
            <?php
            $sql = "SELECT * FROM term_compe_gastro";
            if ($matricula) {
                $sql .= " WHERE matricula = '$matricula'";
            }
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                echo '<div class="table-responsive"><table class="table table-striped table-bordered table-sm">';
                echo '<thead class="table-dark"><tr>';
                echo '<th>ID</th><th>Fecha</th><th>Matrícula</th><th>Alumno</th><th>Semestre</th><th>Carrera</th><th>Competencia</th><th>Encargado</th><th>Dependencia</th><th>Fecha Inicio</th><th>Fecha Término</th><th>Horario</th><th>Nivel</th><th>Actividades</th><th>Días Asistencia</th>';
                echo '</tr></thead><tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    foreach ($row as $value) echo '<td>' . htmlspecialchars($value) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<p>No hay registros en Competencias Gastro.</p>';
            }
            ?>
        </div>
    </div>
</div>





  <!-- Pie de Pagina -->
  <div class="footer-custom mt-auto">
    <div class="container-fluid px-0">
        <div class="row align-items-center mx-0 text-center text-md-start">
              <div class="col-md-4 mb-3 mb-md-0">
                <img src="../sub/logos.png" alt="Logo Gubernamental" class="footer-logo logo logo-principal img-fluid" />
              </div>
              <div class="col-md-4">
                <p class="mb-0 derechos">© 2025 Gobierno del Estado de México. Todos los derechos reservados.</p>
              </div>
              <div class="col-md-4 text-md-end">
                <img src="../sub/logo.png" alt="Logo Educativo" class="footer-logo logo logo-secundario img-fluid" />
              </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
