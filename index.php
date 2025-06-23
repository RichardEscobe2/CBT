<!DOCTYPE html>
<html lang="es">




<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Portal de inicio de sesión para estudiantes CBT1 Estado de México." />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" /> <!-- Estilos de bootstrap online -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,400&display=swap" rel="stylesheet">  <!-- Fuentes de google -->
  <link href="99.css" rel="stylesheet" /> <!-- Link a la hoja de estilos en CSS -->
  
  <title>Inicio de Sesión - CBT1</title>

  <!-- Script para bloquear comandos para ver el codigo -->
  <script>
    document.addEventListener("contextmenu", function (event) {
      event.preventDefault();
    });

    document.addEventListener("keydown", function (event) {
      if (
        (event.ctrlKey && (event.key === "u" || event.key === "U")) ||
        (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "i")) ||
        (event.ctrlKey && event.shiftKey && (event.key === "J" || event.key === "j")) ||
        event.key === "F12"
      ) {
        event.preventDefault();
      }
    });
  </script>
</head>






<body>

<!-- Barra de Navegacion -->
  <nav class="navbar navbar-light bg-white shadow-sm px-4 fixed-top d-flex justify-content-between align-items-center">
    <img src="sub/logos.png" alt="Logo Gubernamental" height="40" class="img-fluid logo logo-principal">
    <img src="sub/logo.png" alt="Logo Educativo" height="65" class="img-fluid logo logo-secundario">
  </nav>
  <div style="height: 90px;"></div>







<!-- CONTENIDO PRINCIPAL -->


  <!-- Mensaje de Error para matricula o contrasena -->
  <div class="container d-flex justify-content-center align-items-center flex-grow-1" style="min-height: calc(100vh - 160px);">
    <div class="w-100" style="max-width: 350px;">
                <?php if(isset($_GET['error'])): ?>
                    <div id="alerta-error" class="alert alert-danger text-center shadow-sm mx-auto rounded-4 animate-slide-in mb-3" role="alert">
                      <strong>Error al iniciar sesión:</strong> Matrícula o contraseña incorrectos.
                      <div class="barra-tiempo mt-2"></div>
                    </div>
                <?php endif; ?>





    <!-- Formulario y inicio de sesion  -->
              <div class="card p-4 shadow-lg rounded-4">
                <h3 class="text-center mb-3">Iniciar Sesión</h3>
                          <form action="verificar.php" method="POST">
                                <div class="mb-3">
                                  <label for="matricula" class="form-label">Matrícula</label>
                                  <input type="text" class="form-control rounded-pill" id="matricula" name="matricula" placeholder="Ingrese su matrícula" required />
                                </div>
                                <div class="mb-3">
                                  <label for="password" class="form-label">Contraseña</label>
                                  <input type="password" class="form-control rounded-pill" id="password" name="contrasena" placeholder="Ingrese su contraseña" required />
                                </div>
                                <button type="submit" class="btn btn-custom w-100 rounded-pill btngu2">Entrar</button>
                          </form>
              </div>
    </div>
  </div>








  <!-- Pie de Pagina -->
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




  <!-- SCRIPT ANIMACIÓN ALERTA -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const alerta = document.getElementById("alerta-error");
      const card = document.querySelector(".card");

      if (alerta) {
        const barra = alerta.querySelector(".barra-tiempo");

        if (barra) {
          barra.style.animation = "none";
          void barra.offsetWidth;
          barra.style.animation = "llenarBarra 5s linear forwards";
        }

        if (card) {
          card.style.transition = "transform 0.5s ease";
          card.style.transform = "scale(1.03)";
        }

        setTimeout(() => {
          alerta.style.transition = "opacity 0.5s ease";
          alerta.style.opacity = "0";

          setTimeout(() => {
            alerta.remove();
            if (card) card.style.transform = "scale(1)";
          }, 500);
        }, 5000);
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
