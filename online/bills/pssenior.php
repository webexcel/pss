<?php
try {
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../login/configi.php');
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/currency.php";

// Composer autoload for FPDF/FPDI
 

error_reporting(0);

$receiptID	=	trim($_GET['r']);
$adno		=	trim($_GET['adno']);
$name		=	trim($_GET['name']);
$fname		=	trim($_GET['fname']);
$standard	=	trim($_GET['std']);
$section	=	trim($_GET['sec']);
$name		=	$name;
$sec		=	$standard.'-'.$section;
/*
$sqlGrp	=	"SELECT `feeGroupName` FROM `v_feestatus` WHERE `Admission_No` = '".$adno."' group by `Admission_No`";
$exeGrp	=	$mysqli->query($sqlGrp);
$rows = $exeGrp->fetch_assoc();
$grpName = $rows['feeGroupName'];
*/
$sqlFeeHistory	=	"SELECT ADMISSION_ID, CLASS_ID, tA.FEE_MODE_REF_NO, tA.RECEIPT_ID, RECEIPT_DATE, tA.FEE_REMARKS, tA.FEE_MODE,tA.YEAR_ID, Amount AS FEE_AMOUNT, tA.FEE_MODE_REF_NO, tC.feehead AS FEE_HEAD, tC.feetype AS FEE_TYPE FROM `fee_receipt` tA LEFT JOIN  fee_transanction tB ON tA.RECEIPT_ID = tB.RECEIPT_ID LEFT JOIN feeheads tC ON tB.feeHead = tC.feeheadId WHERE tA.RECEIPT_ID = '".$receiptID."' ";
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;
$feeDetails = array();
if( $cntFeeHistory > 0 ) {
	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arr	=	array();

		
		$recpid	=  $row['FEE_MODE_REF_NO'];
		$yearid1 =  $row['YEAR_ID'];
		if($yearid1 =='3')
		{
			$yearid = 'Academic Year : 2023 - 24';
		}elseif($yearid1 =='4'){
			$yearid = 'Academic Year : 2024 - 25';
		}elseif($yearid1 =='5'){
			$yearid = 'Academic Year : 2025 - 26';
		}else{
			$yearid = 'Academic Year : 2026 - 27';
		}
		
		$date		=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		$payMode	=	$row['FEE_MODE'];
		$pexp		=	explode('|', $payMode);
		$pmode		=	$pexp[0];
		$pno		=	$pexp[1];
		$pname		=	$pexp[2];
		$FEE_MODE_REF_NO	=	$row['FEE_MODE_REF_NO'];
		$remarks	=	$row['FEE_REMARKS'];
		$arr['FEE_HEAD'] = $row['FEE_HEAD'];
		$arr['FEE_TYPE'] = $row['FEE_TYPE'];
		$arr['FEE_AMOUNT'] = $row['FEE_AMOUNT'];
		$billBookName = $row['billBookName'];
		$totAmount	 += $row['FEE_AMOUNT'];
		$feeDetails[]	=	$arr;
	}
}


/*
define('FPDF_FONTPATH','../FPDF-1.8.1/font');
require_once('../FPDF-1.8.1/fpdf.php');
require_once('../FPDI-1.6.2/fpdi.php');

$pdf = new FPDI("P"); 

$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile("pssBill.pdf"); 
$pdf->SetFont('Times', '', '9');

// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx,0,0);*/
require __DIR__ . '/vendor/autoload.php';
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage('P');
$pdf->SetFont('Times', '', 9);
$pageCount = $pdf->setSourceFile("pssBill.pdf"); 
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page

$pdf->SetXY(30, 35);
//$pdf->Write(0, $recpid);
$pdf->Cell(19, 0, $recpid, 0, 0, 'R', false);

$pdf->SetXY(20, 46);
$pdf->Write(0, $name);

$pdf->SetXY(72, 41);
$pdf->Write(0, $sec);

$pdf->SetXY(60, 46);
$pdf->Write(0, $yearid);

$pdf->SetXY(30, 40);
$pdf->Write(0, $adno);

$pdf->SetXY(72, 35);
$pdf->Write(0, $date);

$pdf->SetXY(74, 117);
$pdf->Cell(20, 0, number_format($totAmount, 2), 0, 0, 'R', false);


$pdf->SetXY(26, 182);
$pdf->Write(0, $pno);

$pos1 = 64;
$pos2 = 64;
$z = 1;
for ($i = 0; $i < count($feeDetails); $i++) {

	$pdf->SetXY(10, $pos1);
	$pdf->Write(0, $z.". ");
	
	$pdf->SetXY(16, $pos2);
	$pdf->Write(0, $feeDetails[$i]['FEE_HEAD']);
	
	$pdf->SetXY(74, $pos2);
	//$pdf->Write(0, number_format($feeDetails[$i]['FEE_AMOUNT'], 2));
	$pdf->Cell(20, 0, number_format($feeDetails[$i]['FEE_AMOUNT'], 2), 0, 0, 'R', false); 
	
	$pos1 += 5;
	$pos2 += 5;
	$z++;
}



$pdf->SetXY(130, 35);
//$pdf->Write(0, $recpid);
$pdf->Cell(22, 0, $recpid, 0, 0, 'R', false);

$pdf->SetXY(123, 46);
$pdf->Write(0, $name);

$pdf->SetXY(175, 41);
$pdf->Write(0, $sec);

$pdf->SetXY(162, 46);
$pdf->Write(0, $yearid);

$pdf->SetXY(133, 40);
$pdf->Write(0, $adno);

$pdf->SetXY(175, 35);
$pdf->Write(0, trim($date));

$pdf->SetXY(178, 117);
$pdf->Cell(20, 0, number_format($totAmount, 2), 0, 0, 'R', false);


$pdf->SetXY(198, 182);
$pdf->Write(0, $pno);


$pos3 = 64;
$pos4 = 64;
$y = 1;
for ($i = 0; $i < count($feeDetails); $i++) {

	$pdf->SetXY(113, $pos3);
	$pdf->Write(0, $y.". ");
	
	$pdf->SetXY(120, $pos4);
	$pdf->Write(0, $feeDetails[$i]['FEE_HEAD']);
	
	$pdf->SetXY(178, $pos4);
	//$pdf->Write(0, number_format($feeDetails[$i]['FEE_AMOUNT'], 2));
	$pdf->Cell(20, 0, number_format($feeDetails[$i]['FEE_AMOUNT'], 2), 0, 0, 'R', false);
	
	$pos3 += 5;
	$pos4 += 5;
	$y++;
}


$obj_currency = new Currency();


$amount = number_format( $totAmount, 2 );
//$obj_currency->get_bd_money_format($amount) . ' : ' . $obj_currency->get_bd_amount_in_text($amount);

$amountinWords	=	"                                ".$obj_currency->get_bd_amount_in_text($totAmount) ." only" ;

$pdf->SetXY(12, 122);
$pdf->MultiCell(75, 6, $amountinWords);

$pdf->SetXY(115, 122);
$pdf->MultiCell(75, 6, $amountinWords);


$pdf->SetXY(28, 138);
$pdf->Write(0, ': '.$FEE_MODE_REF_NO);

$pdf->SetXY(130, 138);
$pdf->Write(0, ': '.$FEE_MODE_REF_NO);

$pdfName	=	strtoupper($name) . "_" . $recpid . "_" . $adno . ".pdf";
$pdf->Output($pdfName, 'I');

} catch (Exception $e) {
	echo "ERROR : " .$e->getMessage();
}

?>

