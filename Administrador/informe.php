<?php
require_once("../Assets/Bases de datos/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el valor del formulario
    $mes_año = $_POST['mes_año']; // Formato: YYYY-MM

    // Separar el año y el mes
    list($año, $mes) = explode('-', $mes_año);

    // Asumiendo que ya tienes la conexión establecida en $conn
    // Primera consulta para obtener las ventas
    $sqlVentas = "SELECT IdVentaPlan, IdPlan, PrecioPlan, FechaVenta 
                  FROM ventaplan 
                  WHERE MONTH(FechaVenta) = $mes AND YEAR(FechaVenta) = $año";

    $resultadoVentas = $conn->query($sqlVentas);

    $ventas = array();
    if ($resultadoVentas->num_rows > 0) {
        while ($fila = $resultadoVentas->fetch_assoc()) {
            $ventas[] = $fila;
        }
    }

    // Segunda consulta para obtener el total de ventas
    $sqlTotalVentas = "SELECT SUM(PrecioPlan) AS TotalVentas 
                       FROM ventaplan 
                       WHERE MONTH(FechaVenta) = $mes AND YEAR(FechaVenta) = $año";

    $resultadoTotalVentas = $conn->query($sqlTotalVentas);

    $totalVentas = 0;
    if ($resultadoTotalVentas->num_rows > 0) {
        $totalVentas = $resultadoTotalVentas->fetch_assoc()['TotalVentas'];
    }

   
}


require_once('../Assets/tcpdf/tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tatsu');
$pdf->SetTitle('Reporte de ventas');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);



$pdf->SetHeaderData('localhost/PROYECTO-FINAL-PAGINA-WEB-/Img/noto-v1_tornado.png', 0, 'Tatsu',  'Reporte de Ventas del '.$mes_año, array(0,64,255), array(0,64,128));

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->SetFont('helvetica', '', 11);

$pdf->AddPage();


$html = '
<style>
h1, h3 {
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;
    color: #333;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, Helvetica, sans-serif;
}
th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}
tr:hover {
    background-color: #ddd;
}
td {
    font-size: 14px;
}
.total-row {
    font-weight: bold;
    background-color: #4CAF50;
    color: white;
}
.total-cell {
    text-align: right;
}
</style>
    <h1>Reporte de ventas: (' . $mes_año . ')</h1>
    <h3>Listado de Ventas</h3>
    <table>
        <tr>
            <th>ID Venta</th>
            <th>ID Plan</th>
            <th>Precio Plan</th>
            <th>Fecha Venta</th>
        </tr>';

// Agregamos los datos de ventas al HTML
foreach ($ventas as $venta) {
    $html .= "
        <tr>
            <td>{$venta['IdVentaPlan']}</td>
            <td>{$venta['IdPlan']}</td>
            <td>{$venta['PrecioPlan']}</td>
            <td>{$venta['FechaVenta']}</td>
        </tr>";
}

// Cerramos la tabla
$html .= '
        <tr style="font-weight:bold;">
            <td colspan="2">Total Ventas</td>
            <td colspan="2">$' . $totalVentas . '</td>
        </tr>
    </table>';


$pdf->writeHTML($html, true, false, false, false, 'C');


// move pointer to last page
$pdf->lastPage();
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Reporte_ventas.pdf', 'I');
?>