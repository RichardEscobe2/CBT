<?php 
require_once 'TCPDF/tcpdf.php';
require_once('conexion.php');

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Traducir meses al español manualmente
function traducirFecha($fecha) {
    $meses = array(
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    );
    $fechaEn = date('d \d\e F \d\e Y', strtotime($fecha));
    return strtr($fechaEn, $meses);
}

$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : (isset($_SESSION['matricula']) ? $_SESSION['matricula'] : null);
if (!$matricula) {
    die("No se ha proporcionado una matrícula válida.");
}

$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');

$query = "SELECT nombre_encargado, cargo, dependencia, nombre_alumno, semestre, carrera, dia1, ay, dia2, hr1, hr2 FROM carta_presentacion WHERE matricula = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error en la consulta: " . $conn->error);
}
$stmt->bind_param("s", $matricula);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();

if (!$datos) {
    die("No se encontraron datos para la matrícula ingresada.");
}

class MYPDF extends TCPDF {
    public function Header() {
        $this->Image('mem.jpg', 8, 10, 210);
        $this->Ln(30);
    }

    public function Footer() {
        $footerHeight = 20;
        $this->SetY(-8 - $footerHeight);
        $this->Image('foot.jpg', 10, $this->GetY(), 195, $footerHeight);
    }
}

$pdf = new MYPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetMargins(20, 60, 20);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();

$pdf->SetFont('Helvetica', '', 10);

// DEPENDENCIA
$pdf->SetFont('', 'B');
$pdf->Cell(131, 1, 'DEPENDENCIA:', 0, 0, 'R');
$pdf->SetFont('', '');
$pdf->Cell(0, 5, 'CBT No.1, CHICOLOAPAN', 0, 1, 'R');

// DEPARTAMENTO
$pdf->SetFont('', 'B');
$pdf->Cell(135, 1, 'DEPARTAMENTO:', 0, 0, 'R');
$pdf->SetFont('', '');
$pdf->Cell(0, 5, 'VINCULACIÓN                ', 0, 1, 'R');

// ASUNTO
$pdf->SetFont('', 'B');
$pdf->Cell(121, 1, 'ASUNTO:', 0, 0, 'R');
$pdf->SetFont('', '');
$pdf->Cell(0, 5, 'CARTA DE PRESENTACIÓN        ', 0, 1, 'R');

// Segunda línea del asunto (sin negritas)
$pdf->Cell(176, 5, 'PRÁCTICAS DE EJECUCIÓN', 0, 1, 'R');

$pdf->Ln(1);

// Fecha en español
$fechaFormateada = traducirFecha($fecha);
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(0, 10, 'Chicoloapan, Méx., a ' . $fechaFormateada, 0, 1, 'R');
$pdf->Ln(2);

// Encabezado del destinatario
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->MultiCell(0, 6, strtoupper($datos['nombre_encargado']), 0, 'L');
$pdf->MultiCell(0, 6, strtoupper($datos['cargo']), 0, 'L');
$pdf->MultiCell(0, 6, 'DE ' . strtoupper($datos['dependencia']), 0, 'L'); 

$pdf->MultiCell(0, 6, 'P R E S E N T E', 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Helvetica', '', 12);
$pdf->setCellHeightRatio(1.5);
$mensajeCompletoHTML = '
<p style="text-align: justify; text-indent: 30px;">
    Por este conducto, el que suscribe Dr. Nicolás Victoria Silva, Director Escolar del CBT No. 1, Chicoloapan., se permite presentar a sus finas atenciones al alumno C. 
    <b>' . strtoupper($datos['nombre_alumno']) . '</b> quien actualmente cursa el ' . $datos['semestre'] . ' semestre de la carrera 
    <b>TÉCNICO EN ' . strtoupper($datos['carrera']) . '</b>, para que se le brinde la oportunidad de realizar sus 
    <b>PRÁCTICAS DE EJECUCIÓN DE COMPETENCIAS</b> y acreditar el logro de las competencias de cada módulo. 
    El alumno cubrirá un total de 100 horas asistiendo los días ' . $datos['dia1'] . ' ' . $datos['ay'] . ' ' . $datos['dia2'] . ' en un horario de ' . $datos['hr1'] . ' a ' . $datos['hr2'] . ' hrs. 
    En un periodo comprendido del 11 de marzo de 2024 al 19 de junio de 2024.<br>
    Agradezco de antemano el apoyo a nuestra institución académica para la formación profesional de los estudiantes, esperando su respuesta favorable por escrito con una carta de aceptación. 
    Sin más por el momento, reciba un cordial saludo.
</p>';


$pdf->writeHTMLCell(0, 0, '', '', $mensajeCompletoHTML, 0, 1, false, true, 'J', true);
$pdf->Ln(7);



// Atentamente
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 6, "A T E N T A M E N T E", 0, 'L');
$pdf->Ln(10);

// Firma
$pdf->Cell(0, 0, '_________________________________________', 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 6, "Dr. Nicolás Victoria Silva", 0, 'L');
$pdf->MultiCell(0, 6, "Director Escolar Del CBT No. 1, CHICOLOAPAN", 0, 'L');

$pdf->Output('Carta_de_Presentacion.pdf', 'D');
?>
