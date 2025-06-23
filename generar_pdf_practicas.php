<?php 
require_once 'TCPDF/tcpdf.php';
require_once('conexion.php');

ini_set('display_errors', 0);
error_reporting(E_ALL);

function traducirFecha($fecha) {
    $meses = array(
        'January' => 'enero', 'February' => 'febrero', 'March' => 'marzo',
        'April' => 'abril', 'May' => 'mayo', 'June' => 'junio',
        'July' => 'julio', 'August' => 'agosto', 'September' => 'septiembre',
        'October' => 'octubre', 'November' => 'noviembre', 'December' => 'diciembre'
    );
    $fechaEn = date('d \d\e F \d\e Y', strtotime($fecha));
    return strtr($fechaEn, $meses);
}

$matricula = $_GET['matricula'] ?? ($_SESSION['matricula'] ?? null);
if (!$matricula) die("No se ha proporcionado una matrícula válida.");

$fecha = $_POST['fecha'] ?? date('Y-m-d');

$query = "SELECT `fecha`, `matricula`, `alumno`, `semestre`, `carrera`, `competencia`, `encargado`, `dependencia`, `fecha_inicio`, `fecha_termino`, `horario`, `nivel`, `actividades`, `dias_asistencia` FROM `term_compe_gastro` WHERE matricula = ?";

$stmt = $conn->prepare($query);
if ($stmt === false) die("Error en la consulta: " . $conn->error);
$stmt->bind_param("s", $matricula);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
if (!$datos) die("No se encontraron datos para la matrícula ingresada.");

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

// Cambios de estilo
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(0, 10, 'CONSTANCIA DE TERMINO', 0, 1, 'C');
$pdf->Cell(0, 6, 'DE PRÁCTICAS DE EJECUCIÓN DE COMPETENCIAS', 0, 1, 'C');
$pdf->Ln(6);

$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 5, "Chicoloapan, Edo. de Méx., a " . traducirFecha($datos['fecha']) . ".", 0, 'R');
$pdf->Ln(4);

$pdf->SetFont('Helvetica', 'B', 12);
$pdf->MultiCell(0, 5, "MTRO. NICOLAS VICTORIA SILVA", 0, 'L');
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 5, "DIRECTOR ESCOLAR DEL CBT No. 1, CHICOLOAPAN", 0, 'L');
$pdf->MultiCell(0, 5, "P R E S E N T E.", 0, 'L');
$pdf->Ln(4);

// Párrafo justificado y con menor interlineado
$texto = "Quien suscribe C. " . $datos['encargado'] . ", HACE CONSTAR, que el alumno (a):";
$pdf->MultiCell(0, 5, $texto, 0, 'J');
$pdf->Ln(4);

$pdf->SetFont('', 'B');
$pdf->MultiCell(0, 6, strtoupper($datos['alumno']), 0, 'C');
$pdf->SetFont('', '');

$pdf -> Ln(4);

$texto2 = "Quien cursa el " . $datos['semestre'] . " semestre de la carrera TÉCNICO EN " . strtoupper($datos['carrera']) . ", ha CONCLUIDO SATISFACTORIAMENTE sus ";
$pdf->MultiCell(0, 5, $texto2, 0, 'L');

$pdf->SetFont('', 'B');
$pdf->Write(5, "Prácticas de Ejecución de Competencias");
$pdf->SetFont('', '');

$pdf->Write(5, ", en este(a) " . $datos['dependencia'] . ", en el período comprendido del ");
$pdf->Write(5, traducirFecha($datos['fecha_inicio']) . " AL " . traducirFecha($datos['fecha_termino']));
$pdf->Write(5, ", los días " . $datos['dias_asistencia'] . " en un horario de " . $datos['horario']);

$pdf->Write(5, ", cumpliendo con un total de ");

$pdf->SetFont('', 'B');
$pdf->SetTextColor(0, 0, 0);
$pdf->Write(5, "100 Hrs.");
$pdf->SetFont('', '');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);

// Competencia
$pdf->SetFont('', 'B');
$pdf->Write(5, "Logrando alcanzar la Competencia ");
$pdf->SetFont('', '');
$pdf->Write(5, "(la Competencia marcada por la Institución): ");
$pdf->Ln(8);

$pdf->SetFont('');
$pdf->MultiCell(0, 5, $datos['competencia'], 0, 'L');
$pdf->SetFont('', '');
$pdf->Ln(3);

$pdf->Write(5, "Obteniendo un Nivel ");
$pdf->SetFont('', 'U');
$pdf->Write(5, $datos['nivel']);
$pdf->SetFont('', '');
$pdf->Write(5, ", El cual se alcanzó al realizar las siguientes Actividades:\n");
$pdf->Ln(3);

// Actividades
$actividades = explode("\n", $datos['actividades']);
foreach ($actividades as $i => $actividad) {
    $pdf->MultiCell(0, 5, ($i + 1) . ". " . trim($actividad), 0, 'L');
}
$pdf->Ln(8);

$pdf->MultiCell(0, 5, "Sin más por el momento me pongo a sus órdenes para cualquier duda o aclaración.", 0, 'J');
$pdf->Ln(6);

$pdf->SetFont('', 'B');
$pdf->MultiCell(0, 6, "ATENTAMENTE", 0, 'C');

$pdf->Output('Carta_de_termino_Practicas_de_Ejecucion.pdf', 'D');
?>