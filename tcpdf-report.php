<?php
require_once "config.php";


//include library
include('library/tcpdf.php');

//make tcpdf object
$pdf = new TCPDF('P', 'mm', 'A4');

//remove default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//add page
$pdf->AddPage();

//add content
//table
$pdf->SetFont('Helvetica', '', 14);
$pdf->Cell(190, 10, "INDIAN INSTITUTE OF TECHNOLOGY PATNA", 0, 1, 'C');

$pdf->SetFont('freesans', '', 14);
$pdf->Cell(190, 10, "भारतीय प्रौद्योगिकी संस्थान पटना", 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(190, 5, "I confirm that the following amount has been credited to the below mentioned Bank Account Number", 0, 1);
$pdf->Ln();
$pdf->Cell(190, 5, "Details:", 0, 1, 'C');
$pdf->Cell(190, 5, "Roll Number:", 0, 1);
$pdf->Cell(190, 5, "Name:", 0, 1);
$pdf->Cell(190, 5, "Account Number:", 0, 1);
$pdf->Cell(190, 5, "IFSC Code:", 0, 1);
$pdf->Cell(190, 5, "Total Leaves:", 0, 1);
$pdf->Cell(190, 5, "Max Leaves Allowed:", 0, 1);
$pdf->Cell(190, 5, "Valid Leaves:", 0, 1);
$pdf->Cell(190, 5, "Mess Charges Per Day:", 0, 1);
$pdf->Cell(190, 5, "Total Rebate:", 0, 1);


$pdf->Ln();

$pdf->Cell(190, 5, "Caretaker Sign.                                          Warden Sign.                                                Student Sign.", 0, 1);


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" nobr="true">
 <tr>
  <th colspan="3" align="center">DETAILS</th>
 </tr>
 <tr>
  <td>1-1</td>
  <td>1-2</td>
  <td>1-3</td>
 </tr>
 <tr>
  <td>2-1</td>
  <td>3-2</td>
  <td>3-3</td>
 </tr>
 <tr>
  <td>3-1</td>
  <td>3-2</td>
  <td>3-3</td>
 </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

//output
$pdf->Output();
