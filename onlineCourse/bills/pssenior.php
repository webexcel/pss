<?php
try {
require_once('../login/configi.php');
require_once("functions.php");
require_once("currency.php");

error_reporting(0);

$recpid		=	trim($_GET['r']);
$adno		=	trim($_GET['adno']);
$name		=	trim($_GET['name']);
$game		=	trim($_GET['game']);
$date1		=	trim($_GET['date']);
$date 		=   date("d-M-Y", strtotime($date1));
$sec		=	trim($_GET['classsec']);
$totAmount  = 	trim($_GET['amount']); 

/*
define('FPDF_FONTPATH','../FPDF-1.8.1/font');
require_once('../FPDF-1.8.1/fpdf.php');
require_once('../FPDI-1.6.2/fpdi.php');

$pdf = new FPDI("P"); 

$pdf->AddPage();

$pdf->setSourceFile("pssBill.pdf"); 
$pdf->SetFont('Times', '', '9');

$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx,0,0);
*/

require __DIR__ . '/vendor/autoload.php';
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage('P');
$pdf->SetFont('Times', '', 9);
$pageCount = $pdf->setSourceFile("pssBill.pdf"); 
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0);

$pdf->SetXY(28, 35);
$pdf->Cell(19, 0, $recpid, 0, 0, 'R', false);

$pdf->SetXY(20, 46);
$pdf->Write(0, $name);

$pdf->SetXY(72, 41);
$pdf->Write(0, $sec);

$pdf->SetXY(30, 40);
$pdf->Write(0, $adno);

$pdf->SetXY(72, 35);
$pdf->Write(0, $date);

$pdf->SetXY(74, 117);
$pdf->Cell(20, 0, number_format($totAmount, 2), 0, 0, 'R', false);


$pos1 = 64;
$pos2 = 64;
$z = 1;

$pdf->SetXY(10, $pos1);
$pdf->Write(0, $z.". ");

$pdf->SetXY(16, $pos2);
$pdf->Write(0, $game);

$pdf->SetXY(74, $pos2);
$pdf->Cell(20, 0, number_format($totAmount, 2), 0, 0, 'R', false); 

$pos1 += 5;
$pos2 += 5;
$z++;


$pdf->SetXY(128, 35);
$pdf->Cell(22, 0, $recpid, 0, 0, 'R', false);

$pdf->SetXY(123, 46);
$pdf->Write(0, $name);

$pdf->SetXY(175, 41);
$pdf->Write(0, $sec);

$pdf->SetXY(133, 40);
$pdf->Write(0, $adno);

$pdf->SetXY(175, 35);
$pdf->Write(0, trim($date));

$pdf->SetXY(178, 117);
$pdf->Cell(20, 0, number_format($totAmount, 2), 0, 0, 'R', false);


$pos3 = 64;
$pos4 = 64;
$y = 1;

$pdf->SetXY(113, $pos3);
$pdf->Write(0, $y.". ");

$pdf->SetXY(120, $pos4);
$pdf->Write(0, $game);

$pdf->SetXY(178, $pos4);
$pdf->Cell(20, 0, number_format($totAmount, 2), 0, 0, 'R', false);

$pos3 += 5;
$pos4 += 5;
$y++;


$obj_currency = new Currency();


$amount = number_format( $totAmount, 2 );
//$obj_currency->get_bd_money_format($amount) . ' : ' . $obj_currency->get_bd_amount_in_text($amount);

$amountinWords	=	"                                ".$obj_currency->get_bd_amount_in_text($totAmount) ." only" ;

$pdf->SetXY(12, 122);
$pdf->MultiCell(75, 6, $amountinWords);

$pdf->SetXY(115, 122);
$pdf->MultiCell(75, 6, $amountinWords);


$pdf->SetXY(28, 138);
$pdf->Write(0, ': '.$recpid);

$pdf->SetXY(130, 138);
$pdf->Write(0, ': '.$recpid);

$pdfName	=	strtoupper($name) . "_" . $recpid . "_" . $adno . ".pdf";
$pdf->Output($pdfName, 'I');

} catch (Exception $e) {
	echo "ERROR : " .$e->getMessage();
}

?>

