<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cards 2x2</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('https://via.placeholder.com/1200x800');
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
    }
    .navbar {
      background-color: white;
      border-bottom: 4px solid #d4af37;
    }
    .navbar img {
      height: 50px;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .card-img-sim {
      height: 350px;
      background-color: #f0f0f0;
      background-image: url('https://via.placeholder.com/300x350?text=Imagen+Ejemplo');
      background-size: cover;
      background-position: center;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }
    .card-body {
      border-top: 2px solid #d4af37;
    }
    .btn-wine {
      background-color: #6c1b1b;
      color: white;
    }
    .btn-wine:hover {
      background-color: #501313;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar d-flex justify-content-between align-items-center px-4 py-2">
  <img src="https://via.placeholder.com/50x50" alt="Izquierda" />
  <h4 class="m-0 text-danger fw-bold">EDUCACIÓN</h4>
  <img src="https://via.placeholder.com/50x50" alt="Derecha" />
</nav>

<!-- Cards 2x2 -->
<div class="container py-5">
  <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
    <!-- Card 1 -->
    <div class="col">
      <div class="card h-100">
        <div class="card-img-sim"></div>
        <div class="card-body text-center">
          <h5 class="card-title">Carta de Presentación</h5>
          <p>Para prácticas profesionales o servicio social.</p>
          <button class="btn btn-wine w-100" data-bs-toggle="modal" data-bs-target="#modal1">Realizar trámite</button>
        </div>
      </div>
    </div>
    <!-- Card 2 -->
    <div class="col">
      <div class="card h-100">
        <div class="card-img-sim"></div>
        <div class="card-body text-center">
          <h5 class="card-title">Prácticas de Ejecucion GASTRONOMIA</h5>
          <p>Competencias o estadías técnicas.</p>
          <button class="btn btn-wine w-100" data-bs-toggle="modal" data-bs-target="#modal2">Realizar trámite</button>
        </div>
      </div>
    </div>
    <!-- Card 3 -->
    <div class="col">
      <div class="card h-100">
        <div class="card-img-sim"></div>
        <div class="card-body text-center">
          <h5 class="card-title">Prácticas de Ejecucion INFORMATICA</h5>
          <p>Documento de participación o asistencia.</p>
          <button class="btn btn-wine w-100" data-bs-toggle="modal" data-bs-target="#modal3">Realizar trámite</button>
        </div>
      </div>
    </div>
    <!-- Card 4 -->
    <div class="col">
      <div class="card h-100">
        <div class="card-img-sim"></div>
        <div class="card-body text-center">
          <h5 class="card-title">Carta de termino Servicio Social</h5>
          <p>Inasistencias por motivos personales.</p>
          <button class="btn btn-wine w-100" data-bs-toggle="modal" data-bs-target="#modal4">Realizar trámite</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modales -->
<div class="modal fade" id="modal1" tabindex="-1"><div class="modal-dialog"><div class="modal-content p-5">Modal 1</div></div></div>
<div class="modal fade" id="modal2" tabindex="-1"><div class="modal-dialog"><div class="modal-content p-5">Modal 2</div></div></div>
<div class="modal fade" id="modal3" tabindex="-1"><div class="modal-dialog"><div class="modal-content p-5">Modal 3</div></div></div>
<div class="modal fade" id="modal4" tabindex="-1"><div class="modal-dialog"><div class="modal-content p-5">Modal 4</div></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
