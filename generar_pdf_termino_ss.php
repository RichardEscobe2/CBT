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

$query = "SELECT `matricula`, `fecha`, `nombre`, `carrera`, `encargado`, `dependencia`, `desempeno`, `fecha_inicio`, `fecha_fin`, `hora_inicio`, `hora_salida` FROM `constancia_termino_ss` WHERE matricula = ?";

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
    // Encabezado vacío
}

public function Footer() {
    // Pie de página vacío
}

}

$pdf = new MYPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetMargins(20, 60, 20);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();

// Fecha
$fechaFormateada = traducirFecha($fecha);
$pdf->SetFont('Helvetica', '', 11);
$pdf->Cell(0, 5, 'Chicoloapan, Edo. de Méx., a ' . $fechaFormateada, 0, 1, 'R');
$pdf->Ln(10);

// Encabezado de destinatario
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->MultiCell(0, 5, 'MTRO. NICOLÁS VICTORIA SILVA', 0, 'L');
$pdf->MultiCell(0, 5, 'DIRECTOR ESCOLAR DEL CBT No. 1, CHICOLOAPAN', 0, 'L');
$pdf->MultiCell(0, 5, 'P R E S E N T E.', 0, 'L');
$pdf->Ln(10);

// Cuerpo
$pdf->SetFont('Helvetica', '', 11);
$pdf->setCellHeightRatio(1.5);

$mensajeCompletoHTML = '
<p style="text-align: justify; text-indent: 30px;">
    El que suscribe C. <b>' . strtoupper($datos['encargado']) . '</b>, propietario de 
    <b>' . strtoupper($datos['dependencia']) . '</b> <b><u>HACE CONSTAR</u></b>, que el alumno(a):
</p>

<p style="text-align: center;">
    <b>' . strtoupper($datos['nombre']) . ' </b>
</p>

<p style="text-align: justify; text-indent: 30px;">
    Quien cursa la Carrera de <b>TÉCNICO EN ' . strtoupper($datos['carrera']) . '</b>, ha concluido 
    <b>SATISFACTORIAMENTE</b> su Servicio Social en este establecimiento, en el periodo comprendido del 
    <b>' . $datos['fecha_inicio'] . '</b> al <b>' . $datos['fecha_fin'] . '</b>, de lunes a viernes en un horario de 
    ' . $datos['hora_inicio'] . ' a ' . $datos['hora_salida'] . ' hrs., cubriendo un total de 480 horas.
    en un periodo no menor a seis meses.
</p>

<p style="text-align: justify; text-indent: 30px;">
    Compartiendo su experiencia, conocimiento y recursos para el desarrollo armónico; logrando alcanzar un 
    <b>___' . strtoupper($datos['desempeno']) . '___</b> Nivel de Desempeño de sus Competencias Profesionales.
</p>

<p style="text-align: justify; text-indent: 30px;">
    Sin más por el momento me pongo a sus órdenes para cualquier duda o aclaración.
</p>
';

$pdf->writeHTMLCell(0, 0, '', '', $mensajeCompletoHTML, 0, 1, false, true, 'J', true);
$pdf->Ln(10);

// ATENTAMENTE
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 6, 'ATENTAMENTE', 0, 'C');

$pdf->Ln(40); // Aumenta este valor si quieres que la línea esté más abajo, pero sin pasar del margen

// Obtiene el centro horizontal y dibuja una línea de 100 mm
$pageWidth = $pdf->getPageWidth();
$lineWidth = 100;
$startX = ($pageWidth - $lineWidth) / 2;
$currentY = $pdf->GetY();

// Línea centrada más abajo
$pdf->Line($startX, $currentY, $startX + $lineWidth, $currentY);






$pdf->Output('Constancia_de_termino_Servicio_Social.pdf', 'D');
?>
