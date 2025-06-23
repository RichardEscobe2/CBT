<?php

//Aqui verificamos si hay alguna sesion creada, si no creamos una nueva sesion

      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }


      // Regeneramos el ID de sesión para prevenir ataques
      if (!isset($_SESSION['initiated'])) {
          session_regenerate_id(true); // Regenerar el ID de sesión
          $_SESSION['initiated'] = true;
      }

      // Verifica si la sesión contiene al usuario
      if (!isset($_SESSION["usuario"])) {
          // Si no existe la sesión, redirige al login
          header("Location: index.php");
          exit();
      }

      // Verifica que la IP y el User-Agent sean los mismos
      if (isset($_SESSION['IP']) && isset($_SESSION['UA'])) {
          if ($_SESSION['IP'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['UA'] !== $_SERVER['HTTP_USER_AGENT']) {
              // Si la IP o User-Agent no coinciden, destruir la sesión y redirigir
              session_unset();
              session_destroy();
              header("Location: index.php");
              exit();
          }
      } else {
          // Si es la primera vez que se accede a la página después de iniciar sesión
          $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
      }

//Como se trabajara con la hora definimos la zona horaria para trabajar
date_default_timezone_set('America/Mexico_City'); 


include("conexion.php");
$encargado_bd = "";
$dependencia_bd = "";
$horario_bd = "";



//Aqui verificamos que los datos del formulario se hayan enviado correctamente
if (isset($_SESSION['matricula'])) {
    $matricula = $_SESSION['matricula'];

// Todo esto son las consultas para obtener los datos de las otras BD y juntarlos o tenerlos para usarlos en los otros dos formularios
              // Consulta a la base de datos para obtener los datos de encargado, dependencia y horario
              $query = "SELECT nombre_encargado, dependencia, hr1, hr2 FROM carta_presentacion WHERE matricula = ? ORDER BY fecha DESC LIMIT 1";
              $stmt = $conn->prepare($query);
              $stmt->bind_param("s", $matricula);
              $stmt->execute();
              $stmt->bind_result($encargado_bd, $dependencia_bd, $hr1, $hr2);

              //Una vez obtenidos los datos de las horas las vamos a concatenar con un guion entre las variables de las fechas y asi creamos una nueva variable con la fecha en un nuevo formato
              if ($stmt->fetch()) {
                  $horario_bd = $hr1 . " - " . $hr2; 
              }

              $stmt->close();
          }

          //Ahora aqui de la BD vamos a seleccionar los dias que va a realizar el alumno y los vamoos a concatenar para usarlo mas adelante
          $query_dias = "SELECT dia1, ay, dia2 FROM carta_presentacion WHERE matricula = ? ORDER BY fecha DESC LIMIT 1";
          $stmt_dias = $conn->prepare($query_dias);
          $stmt_dias->bind_param("s", $matricula);
          $stmt_dias->execute();
          $stmt_dias->bind_result($dia1, $ay, $dia2);

          $dias_asistencia_bd = '';
          if ($stmt_dias->fetch()) {
              $dias_asistencia_bd = $dia1 . ' ' . $ay . ' ' . $dia2; 
          }

          $stmt_dias->close();

          //Y aqui vamos a extraer el campo de semestre para pasarlo directo alos otros formularios
          $query_semestre = "SELECT semestre FROM carta_presentacion WHERE matricula = ? ORDER BY fecha DESC LIMIT 1";
          $stmt_semestre = $conn->prepare($query_semestre);
          $stmt_semestre->bind_param("s", $matricula);
          $stmt_semestre->execute();
          $stmt_semestre->bind_result($semestre_bd);

          $semestre = ''; 
          if ($stmt_semestre->fetch()) {
              $semestre = $semestre_bd; 
          }

$stmt_semestre->close();

?>







<!DOCTYPE html>
<html lang="es">




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.7/dist/css/tempus-dominus.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href = "99.css" rel = "stylesheet">

    <title>Menú by Ricardo Escobedo</title>

    
    <script>
    document.addEventListener("contextmenu", function(event) {
        event.preventDefault();
    });

    document.addEventListener("keydown", function(event) {
        if (event.ctrlKey && (event.key === "U" || event.key === "u")) {
            event.preventDefault();
        }
        if (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "i")) {
            event.preventDefault();
        }
        if (event.ctrlKey && event.shiftKey && (event.key  === "J" || event.key === "j")) {
            event.preventDefault();
        }
        if (event.key === "F12") {
            event.preventDefault();
        }
    });
    </script>

</head>






<body>


<!-- BARRA DE NAVEGACION -->
          <div class="navbar-custom">
            <div class="navbar-content">
                <img src="sub/logos.png" alt="Logo Gubernamental" class="logo-navbar">
                  <div>
                        <!-- Botón visible solo en pantallas grandes -->
                        <a href="logout.php" class="btn btngu2 d-none d-md-inline">Cerrar Sesión</a>
                        <!-- Icono circular visible solo en pantallas pequeñas -->
                        <a href="logout.php" class="btn btngu2 d-inline d-md-none">
                          <i class="bi bi-box-arrow-right"></i>
                        </a>
                  </div>
            </div>
          </div>




<div class="container mt-5 pt-5">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 gx-5 gy-4 justify-content-center">

                  <!-- CARD 1 -->
                  <div class="col">
                    <div class="card h-100">
                              <img src="card-presentacion.jpg" class="card-img" alt="Image 1">
                              <div class="card-body">
                                  <h5 class="card-title">Carta de Presentacion</h5><br>
                                  <button type="button" class="btn btngu2" data-bs-toggle="modal" data-bs-target="#modal1">
                                      Realizar tramite
                                  </button>
                              </div>
                          </div>
                      </div>



              <!-- CARD 2 -->
                      <div class="col">
                          <div class="card h-100">
                              <img src="card-presentacion.jpg" class="card-img" alt="Image 2">
                              <div class="card-body">
                                  <h5 class="card-title">Carta de Termino De Practicas de Ejecucion Gastronomia</h5>
                                  <button type="button" class="btn btngu2" data-bs-toggle="modal" data-bs-target="#modal2">
                                  Realizar tramite
                                  </button>
                              </div>
                          </div>
                      </div>



              <!-- CARD 3 -->
                      <div class="col">
                          <div class="card h-100">
                              <img src="card-presentacion.jpg" class="card-img" alt="Image 3">
                              <div class="card-body">
                                  <h5 class="card-title">Carta de Termino De Practicas de Ejecucion Informatica</h5>
                                  <button type="button" class="btn btngu2" data-bs-toggle="modal" data-bs-target="#modal3">Realizar tramite</button>
                              </div>
                          </div>
                      </div>


              <!-- CARD 4 -->
                          <div class="col">
                            <div class="card h-100">
                                  <img src="card-presentacion.jpg" class="card-img" alt="Image 4">
                                  <div class="card-body">
                                      <h5 class="card-title">Constancia de Termino de Servicio Social</h5>
                                      <br>
                                      <button type="button" class="btn btngu2" data-bs-toggle="modal" data-bs-target="#modal4">Realizar tramite</button>
                                  </div>
                            </div>
                          </div>

  </div>
</div>








<!-- Modal 1 -->
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" id = "superior">
        <h1 class=" modal-title  fs-5" id="modal1Label">Carta de Presentacion</h1>
        <button type="button" class="cls btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
      <form action="sub/guardar_carta.php" method="POST" id="modal1Form">
      <div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Fecha</label>
        <input type="date" class="form-control" id = "placehldrs-inhabltds" name="fecha" value="<?= date('Y-m-d'); ?>" readonly>
    </div>
    <div class="col-md-6">
    <label class="form-label">Matrícula</label>
    <input type="text" name="matricula" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($_SESSION['matricula']) ? $_SESSION['matricula'] : 'Valor predeterminado'; ?>" readonly>




    </div>
</div>
<!-- Segunda fila -->
<div class="row mb-3">
  <div class="col-md-4">
    <label class="form-label">Nombre del Alumno</label>
    <input type="text" class="form-control" name="nombre_alumno" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Semestre</label>
    <select class="form-select" id="competencia" name="semestre" required>
      <option value="" selected disabled>Ej. 2°, 4°, 6°</option>
      <option value="2do">2°</option>
      <option value="3er">3°</option>
      <option value="4to">4°</option>
      <option value="5to">5°</option>
      <option value="6to">6°</option>
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Carrera</label>
    <select class="form-select" name="carrera" id="competencia" required>
      <option value="" selected disabled>Selecciona tu carrera</option>
      <option value="Gastronomia">Gastronomía</option>
      <option value="Informatica">Informática</option>
    </select>
  </div>
</div>

<!-- Tercer fila -->
<div class="row mb-3">
  <div class="col-md-4">
    <label class="form-label">Persona Responsable</label>
    <input type="text" class="form-control" name="nombre_encargado" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Puesto que Desempeña</label>
    <input type="text" class="form-control" name="cargo" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Dependencia</label>
    <input type="text" class="form-control" name="dependencia" required>
  </div>
</div>

<!-- Última fila: días y horarios -->
<div class="row mb-3">

  <div class="col-md-2">
  <label for="hr1" class="form-label">Dias de Asistencia</label>
    <select class="form-select" id="competencia" name="dia1" required>
      <option value="" selected disabled>Día 1</option>
      <option value="Lunes">Lunes</option>
      <option value="Martes">Martes</option>
      <option value="Miercoles">Miércoles</option>
      <option value="Jueves">Jueves</option>
      <option value="Viernes">Viernes</option>
    </select>
  </div>

  <div class="col-md-1">
  <label for="hr1" class="form-label"><br></label>
    <input type="text" class="form-control" id="placehldrs-inhabltds" name="ay" value="A" readonly required>
  </div>

  <div class="col-md-2">
  <label for="hr1" class="form-label"><br></label>
    <select class="form-select"  id="competencia" name="dia2" required>
      <option value="" selected disabled>Día 2</option>
      <option value="Lunes">Lunes</option>
      <option value="Martes">Martes</option>
      <option value="Miercoles">Miércoles</option>
      <option value="Jueves">Jueves</option>
      <option value="Viernes">Viernes</option>
    </select>
  </div>

  <div class="col-md-3">
  <label for="hr1" class="form-label">Hora Entrada</label>
  <input type="time" class="form-control" id="hr1" name="hr1" required>
</div>

<div class="col-md-3">
  <label for="hr2" class="form-label">Hora Salida</label>
  <input type="time" class="form-control" id="hr2" name="hr2" required>
</div>

</div>

             
          

<div class="mb-3 d-flex justify-content-center">
  <button type="submit" class="btn btngu" style="width: 50%;">
    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
    <span class="button-text">Guardar</span>
  </button>
</div>

        </form>
      </div>
      
    </div>
  </div>
</div>





<!-- Modal 2 -->
<div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id="superior">
        <h1 class="modal-title fs-5" id="modal2Label">Carta de Termino de Practicas de Ejecucion Gastronomia</h1>
        <button type="button" class="cls btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="mensaje-modal" class="alert text-center" role="alert">
  Recuerda: Los demás formularios usan los datos de tu 
  <span class="subrayado">Carta de Presentación</span>. 
  Si hiciste algún cambio, actualízala primero para evitar errores.
  <div id="barra-tiempo"></div> <!-- Barra de tiempo -->
</div>


<div>
        <form action="sub/guardar_practi_gastro.php" method="POST">

          <!-- Primera fila: fecha y matrícula -->
          <div class="row mb-3">
            <div class="col-md-6">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" id = "placehldrs-inhabltds" name="fecha" value="<?= date('Y-m-d'); ?>" readonly>
            </div>
            <div class="col-md-6">
            <label class="form-label">Matrícula</label>
    <input type="text" name="matricula" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($_SESSION['matricula']) ? $_SESSION['matricula'] : 'Valor predeterminado'; ?>" readonly>

            </div>
          </div>

          <!-- Segunda fila: Alumno en media fila, Semestre y Carrera juntos -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="alumno" class="form-label">Nombre del Alumno</label>
              <input type="text" class="form-control" id="alumno" name="alumno" required>
            </div>
            <div class="col-md-3">
  <label for="semestre" class="form-label">Semestre</label>
  <input type="text" class="form-control" id="placehldrs-inhabltds" name="semestre" value="<?= isset($semestre_bd) ? $semestre_bd : 'Sin datos'; ?>" readonly required>
</div>

        <div class="col-md-3">
        <label for  ="carrera" class="form-label">Carrera</label>
        <input type="text" class="form-control" id="placehldrs-inhabltds" name="carrera" value="Gastronomía" readonly required>
        </div>
        </div>
          <!-- Tercera fila: competencia -->
          <div class="row mb-3">
  <div class="col-12">
    <label for="competencia" class="form-label">Competencia</label>
    <select class="form-select" id="competencia" name="competencia" required>
      <option value="">Selecciona...</option>
      <option value="Ejemplo 1">Ejemplo 1</option>
      <option value="Ejemplo 2">Ejemplo 2</option>
      <option value="Ejemplo 3">Ejemplo 3</option>
    </select>
  </div>
</div>

          <!-- Cuarta fila: encargado y dependencia -->
          <div class="row mb-3">
            <div class="col-md-6">
            <label class="form-label">Persona Responsable</label>
            <input type="text" name="encargado" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($encargado_bd) ? $encargado_bd : 'Sin datos'; ?>" readonly>

            </div>
            <div class="col-md-6">
            <label class="form-label">Dependencia</label>
            <input type="text" name="dependencia" class="form-control"  id = "placehldrs-inhabltds" value="<?= isset($dependencia_bd) ? $dependencia_bd : 'Sin datos'; ?>" readonly>

            </div>
          </div>

          <!-- Quinta fila: fecha de inicio y fecha de término -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fecha_inicio" class="form-label ">Fecha de Inicio</label>
              <input type="date" class="form-control custom-date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="col-md-6">
              <label for="fecha_termino" class="form-label">Fecha de Término</label>
              <input type="date" class="form-control custom-date" id="fecha_termino" name="fecha_termino" required>
            </div>
          </div>

          <!-- Sexta fila: horario, desempeño y días de asistencia -->
<div class="row mb-3">
<div class="col-md-4">
<label for="dias_asistencia" class="form-label">Días de Asistencia</label>
  <input type="text" name="dias_asistencia" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($dias_asistencia_bd) ? $dias_asistencia_bd : 'Sin datos'; ?>" readonly>
  </div>

  <div class="col-md-4">
    <label class="form-label">Horario de Asistencia</label>
    <input type="text" name="horario" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($horario_bd) ? $horario_bd : 'Sin datos'; ?>" readonly>
  </div>

  <div class="col-md-4">
    <label for="nivel" class="form-label">Desempeño</label>
    <select class="form-select" id="nivel" name="nivel" required>
      <option value="">Selecciona...</option>
      <option value="Bueno">Bueno</option>
      <option value="Excelente">Excelente</option>
    </select>
  </div>
  </div>

  


          <!-- Séptima fila: actividades -->
          <div class="row mb-3">
            <div class="col-12"> 
              <label for="actividades" class="form-label">Actividades</label>
              <textarea class="form-control" id="actividades" name="actividades" rows="5" required></textarea>
            </div>
          </div>

          <div class="mb-3 d-flex justify-content-center">
  <button type="submit" class="btn btngu" style="width: 50%;">
    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
    <span class="button-text">Guardar</span>
  </button>
</div>

        </form>
      </div>
    </div>
  </div>
</div>
  </div>













<!-- Modal 3 -->
<div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" id = "superior">
        <h1 class="modal-title fs-5" id="modal3Label">Carta de Termino de Practicas de Ejecucion Informatica</h1>
        <button type="button" class="cls btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
      <div id="mensaje-modal" class="alert text-center" role="alert">
      Recuerda: Los demás formularios usan los datos de tu 
  <span class="subrayado">Carta de Presentación</span>. 
  Si hiciste algún cambio, actualízala primero para evitar errores.
  <div id="barra-tiempo"></div> <!-- Barra de tiempo -->
</div>

<div>
      <form action="sub/guardar_practi_gastro.php" method="POST">

<!-- Primera fila: fecha y matrícula -->
<div class="row mb-3">
  <div class="col-md-6">
  <label class="form-label">Fecha</label>
  <input type="date" class="form-control" name="fecha" id = "placehldrs-inhabltds" value="<?= date('Y-m-d'); ?>" readonly>
  </div>
  <div class="col-md-6">
  <label class="form-label">Matrícula</label>
<input type="text" name="matricula" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($_SESSION['matricula']) ? $_SESSION['matricula'] : 'Valor predeterminado'; ?>" readonly>

  </div>
</div>

<!-- Segunda fila: Alumno en media fila, Semestre y Carrera juntos -->
<div class="row mb-3">
  <div class="col-md-6">
    <label for="alumno" class="form-label">Nombre del Alumno</label>
    <input type="text" class="form-control" id="alumno" name="alumno" required>
  </div>
  <div class="col-md-3">
  <label for="semestre" class="form-label">Semestre</label>
  <input type="text" class="form-control" id="placehldrs-inhabltds" name="semestre" value="<?= isset($semestre_bd) ? $semestre_bd : 'Sin datos'; ?>" readonly required>
</div>

<div class="col-md-3">
<label for  ="carrera" class="form-label">Carrera</label>
<input type="text" class="form-control" id="placehldrs-inhabltds" name="carrera" value="Informática " readonly required>
</div>
</div>
<!-- Tercera fila: competencia -->
<div class="row mb-3">
<div class="col-12">
<label for="competencia" class="form-label">Competencia</label>
<select class="form-select" id="competencia" name="competencia" required>
<option value="">Selecciona...</option>
<option value="1">Ejemplo 1</option>
<option value="2">Ejemplo 2</option>
<option value="3">Ejemplo 3</option>
<option value="4">Ejemplo 4</option>
<option value="5">Ejemplo 5</option>
</select>
</div>
</div>

<!-- Cuarta fila: encargado y dependencia -->
<div class="row mb-3">
            <div class="col-md-6">
            <label class="form-label">Persona Responsable</label>
<input type="text" name="encargado" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($encargado_bd) ? $encargado_bd : 'Sin datos'; ?>" readonly>

            </div>
            <div class="col-md-6">
            <label class="form-label">Dependencia</label>
<input type="text" name="dependencia" class="form-control"  id = "placehldrs-inhabltds" value="<?= isset($dependencia_bd) ? $dependencia_bd : 'Sin datos'; ?>" readonly>

            </div>
          </div>

<!-- Quinta fila: fecha de inicio y fecha de término -->
<div class="row mb-3">
  <div class="col-md-6">
    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
    <input type="date" class="form-control custom-date" id="fecha_inicio" name="fecha_inicio" required>
  </div>
  <div class="col-md-6">
    <label for="fecha_termino" class="form-label">Fecha de Término</label>
    <input type="date" class="form-control custom-date" id="fecha_termino" name="fecha_termino" required>
  </div>
</div>

 <!-- Sexta fila: horario, desempeño y días de asistencia -->
 <div class="row mb-3">
<div class="col-md-4">
<label for="dias_asistencia" class="form-label">Días de Asistencia</label>
  <input type="text" name="dias_asistencia" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($dias_asistencia_bd) ? $dias_asistencia_bd : 'Sin datos'; ?>" readonly>
  </div>

  <div class="col-md-4">
    <label class="form-label">Horario de Asistencia</label>
    <input type="text" name="horario" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($horario_bd) ? $horario_bd : 'Sin datos'; ?>" readonly>
  </div>

  <div class="col-md-4">
    <label for="nivel" class="form-label">Desempeño</label>
    <select class="form-select" id="nivel" name="nivel" required>
      <option value="">Selecciona...</option>
      <option value="Bueno">Bueno</option>
      <option value="Excelente">Excelente</option>
    </select>
  </div>
  </div>

<!-- Séptima fila: actividades -->
<div class="row mb-3">
  <div class="col-12">
    <label for="actividades" class="form-label">Actividades</label>
    <textarea class="form-control" id="actividades" name="actividades" rows="5" required></textarea>
  </div>
</div>

<div class="mb-3 d-flex justify-content-center">
  <button type="submit" class="btn btngu" style="width: 50%;">
    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
    <span class="button-text">Guardar</span>
  </button>
</div>

</form>
      </div>
    </div>
  </div>
</div>
</div>









<!-- Modal 4 -->
<div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal más ancho -->
    <div class="modal-content">
      <div class="modal-header" id="superior">
        <h1 class="modal-title fs-5" id="modal4Label">Constancia de Término de Servicio Social</h1>
        <button type="button" class="cls btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="sub/guardar_termino_SS.php" method="POST">

<input type="date" class="form-control d-none" name="fecha" value="<?= date('Y-m-d'); ?>">

          <!-- Fila 2: Nombre (mitad), Carrera y Matrícula (mitades de la otra mitad) -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre del Alumno</label>
              <input type="text" class="form-control" id="nombre" name="nombre">
            </div>


            <div class="col-md-3">
                <label for="carrera" class="form-label">Carrera</label>
                <select class="form-select" id="carrera" name="carrera" required>
                  <option value="">Selecciona...</option>
                  <option value="Gastronomia">Gastronomia</option>
                  <option value="Informatica">Informatica </option>
                </select>
            </div>

            <div class="col-md-3">
              <label for="matricula" class="form-label">Matrícula</label>
              <input type="text" name="matricula" class="form-control" id = "placehldrs-inhabltds" value="<?= isset($_SESSION['matricula']) ? $_SESSION['matricula'] : 'Valor predeterminado'; ?>" readonly>
            </div>
          </div>

          <!-- Fila 3: Encargado, Dependencia, Desempeño -->
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="encargado" class="form-label">Persona Responsable</label>
              <input type="text" class="form-control" id="encargado" name="encargado">
            </div>
            <div class="col-md-4">
              <label for="dependencia" class="form-label">Dependencia</label>
              <input type="text" class="form-control" id="dependencia" name="dependencia">
            </div>
            <div class="col-md-4">
                <label for="desempeno" class="form-label">Desempeño</label>
                <select class="form-select" id="desempeno" name="desempeno" required>
                  <option value="">Selecciona...</option>
                  <option value="Bueno">Bueno</option>
                  <option value="Excelente">Excelente </option>
                </select>
            </div>
            </div>

          <!-- Fila 4: Dos fechas y dos horas -->
          <div class="row mb-3">
          <div class="col-md-3">
              <label for="fecha_inicio" class="form-label ">Fecha de Inicio</label>
              <input type="date" class="form-control custom-date" id="fecha_inicio" name="fecha_inicio">
            </div>
            <div class="col-md-3">
              <label for="fecha_fin" class="form-label ">Fecha de Finalizacion</label>
              <input type="date" class="form-control custom-date" id="fecha_fin" name="fecha_fin">
            </div>
            <div class="col-md-3">
              <label for="hora_inicio" class="form-label">Hora Entrada</label>
              <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
            </div>
            <div class="col-md-3">
              <label for="hora_salida" class="form-label">Hora Salida</label>
              <input type="time" class="form-control" id="hora_salida" name="hora_salida">
            </div>
          </div>

          <!-- Botón de guardar -->
          <div class="mb-3 d-flex justify-content-center">
  <button type="submit" class="btn btngu" style="width: 50%;">
    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
    <span class="button-text">Guardar</span>
  </button>
</div>

        </form>
      </div>
    </div>
  </div>
</div>







<div class="footer-custom mt-auto">
  <div class="container-fluid px-0">
    <div class="row align-items-center mx-0 text-center text-md-start">
      <div class="col-md-4 mb-3 mb-md-0">
        <img src="sub/logos.png" alt="Logo Gubernamental" class="footer-logo logo logo-principal img-fluid" />
      </div>
      <div class="col-md-4">
        <p class="mb-0 derechos">© 2025 Gobierno del Estado de México. Todos los derechos reservados.</p>
      </div>
      <div class="col-md-4 text-md-end">
        <img src="sub/logo.png" alt="Logo Educativo" class="footer-logo logo logo-secundario img-fluid" />
      </div>
    </div>
  </div>
</div>





    <?php if (isset($_GET['expirada']) && $_GET['expirada'] == 1): ?>
<script>
    alert("⚠️ Tu sesión ha sido cerrada por inactividad.");
</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modales = ['modal2', 'modal3']; 
  modales.forEach(modalId => {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.addEventListener('shown.bs.modal', function () {
        const mensaje = modal.querySelector('#mensaje-modal');
        if (mensaje) {
          mensaje.style.display = 'block';

        
          const barra = mensaje.querySelector('#barra-tiempo');
          if (barra) {
            barra.style.animation = 'none';
        
            void barra.offsetWidth;
            barra.style.animation = 'llenarBarra 7s linear forwards';
          }

        
          setTimeout(() => {
            mensaje.style.display = 'none';
          }, 7000);
        }
      });
    }
  });
});
</script>
<script>
  const fechaPicker = new tempusDominus.TempusDominus(document.getElementById('fechaPicker'), {
    localization: {
      locale: 'es',
      format: 'dd/MM/yyyy'
    },
    display: {
      components: {
        calendar: true,
        date: true,
        month: true,
        year: true,
        decades: false,
        clock: false
      },
      buttons: {
        today: true,
        clear: true
      }
    }
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // VALIDACIÓN DE HORAS (EXISTENTE - MODIFICADO PARA SER MÁS ESPECÍFICO)
  const modalsConHoras = document.querySelectorAll('.modal'); 
  modalsConHoras.forEach(modal => {
    const form = modal.querySelector('form');
    if (form) {
      const hrEntrada = form.querySelector('input[name="hr1"], input[name="hora_inicio"]'); 
      const hrSalida = form.querySelector('input[name="hr2"], input[name="hora_salida"]');

      if (hrEntrada && hrSalida) {
        form.addEventListener('submit', function (e) {
          const horaEntradaVal = hrEntrada.value;
          const horaSalidaVal = hrSalida.value;

          if (horaEntradaVal && horaSalidaVal && horaEntradaVal >= horaSalidaVal) {
            e.preventDefault(); 
            alert('La hora de entrada debe ser menor que la hora de salida.');
            
            const button = form.querySelector('button[type="submit"].is-loading');
            if (button) {
                const spinner = button.querySelector('.spinner-border');
                const buttonText = button.querySelector('.button-text');
                if (spinner) spinner.classList.add('d-none');
                if (buttonText) buttonText.textContent = 'Guardar'; 
                button.disabled = false;
                button.classList.remove('is-loading');
            }
          }
        });
      }
    }
  });

  // INDICADOR DE CARGA EN BOTONES DE SUBMIT
  const allForms = document.querySelectorAll('form');
  allForms.forEach(form => {
    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
        form.classList.add('was-validated');
        return; 
      }
      
      const button = form.querySelector('button[type="submit"]');
      if (button && !button.disabled && !button.classList.contains('is-loading')) {
        const spinner = button.querySelector('.spinner-border');
        const buttonText = button.querySelector('.button-text'); 

        if (spinner) spinner.classList.remove('d-none');
        if (buttonText) buttonText.textContent = 'Guardando...';
        button.disabled = true;
        button.classList.add('is-loading');
      } else if (button && button.classList.contains('is-loading')) {
        event.preventDefault();
      }
    });
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
