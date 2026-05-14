<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);
try {

require_once('../configi.php');
require_once("functions.php");
require_once("currency.php");

error_reporting(1);


$rid	=	trim($_GET['r']);

$sqlFeeHistory	=	"SELECT * FROM `application_prekg` WHERE `id` = '".$rid."'";
$exeFeeHistory	=	$dbconnect->query($sqlFeeHistory);
$row = $exeFeeHistory->fetch_assoc();
$fno = $row['fno'];
$applied = $row['applied'];
$name = $row['name'];
$dob1 = $row['dob'];
$dob =  date("d-m-Y", strtotime($dob1));
/*$parts = split('-', $dob); // could also use split() 
$parts[0];
$parts[1]; 
$parts[2];*/

$bday = new DateTime($dob1); // Your date of birth
$maxdate1 = '31.05.2026';
$maxdate =  date("d.m.y", strtotime($maxdate1));
$today = new Datetime($maxdate);
$diff = $today->diff($bday);
$year = $diff->y;
$month = $diff->m;

$bg = $row['bg'];
$gender = $row['gender'];
$nationality = $row['nationality'];
$religion = $row['religion'];
$community = $row['community'];
$addressP1 = $row['addressP'];
$pincode1 = $row['pincode'];
$addressP = $addressP1.' - '.$pincode1;
$health = $row['health'];
$contact = $row['contact'];
$contact1 = $row['contact1'];
$email = strtolower($row['email']);
$aadhar = $row['aadhar'];
$fname = $row['fname'];
$fquali = $row['fquali'];
$gender = $row['gender'];
$focc = $row['focc'];
$fincome = $row['fincome'];
$foccdetails1 = $row['foccdetails'];
$foccdetails = $focc.','.$foccdetails1;

$mname = $row['mname'];
$mquali = $row['mquali'];
$mocc = $row['mocc'];
$mincome = $row['mincome'];
$moccdetails1 = $row['moccdetails'];
$moccdetails = $mocc.','.$moccdetails1;

$distance = $row['distance'];

$sname1 = $row['sname1'];
$adno1 = $row['adno1'];
$sib1 = $sname1.' - '.$adno1;

$sname2 = $row['sname2'];
$adno2 = $row['adno2'];
$sib2 = $sname2.' - '.$adno2;

$class1 = $row['class1'];
$sec1 = $row['sec1'];
$sibclass1 = $class1.'-'.$sec1;

$class2 = $row['class2'];
$sec2 = $row['sec2'];
$sibclass2 = $class2.'-'.$sec2;



$aname = $row['aname'];

if($aname != ''){
	$aluNo = 'YES';
}else{
	$aluNo = 'NO';
}
$yadno = $row['yadno'];
$yclass = $row['yclass'];
$ycom = $row['ycom'];
$cclass = $row['cclass'];
$alumni = $row['alumni'];

$NoYear = $ycom.'-'.$yadno;

/*
define('FPDF_FONTPATH','FPDF-1.8.1/font');
require_once('FPDF-1.8.1/fpdf.php');
require_once('FPDI-1.6.2/fpdi.php');

$pdf = new FPDI("P"); 
$pageCount = $pdf->setSourceFile("kg26.pdf"); 
$pdf->SetFont('Times', '', '12');


$pageNo = 1;
$tplIdx = $pdf->importPage($pageNo);

$pdf->AddPage();
$pdf->useTemplate($tplIdx, null, null, 0, 0, true);
*/
require __DIR__ . '/vendor/autoload.php';
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage('P');
$pdf->SetFont('Times', '', '12');
$pageCount = $pdf->setSourceFile("kg26.pdf"); 	
$pageNo = 1;
$tplIdx = $pdf->importPage($pageNo);
$pdf->useTemplate($tplIdx, 0,0);


$pdf->SetXY(175, 110);
$pdf->Write(2, $fno);

$pdf->SetXY(115, 112);
$pdf->Write(2, $applied);

$pdf->SetXY(85, 126);
$pdf->Write(2, $name);

$pdf->SetXY(85, 139);
$pdf->Write(2, $dob);
/*
$pdf->SetXY(98, 119);
$pdf->Write(2, $year);	

$pdf->SetXY(150, 119);
$pdf->Write(2, $month);

/*
$pdf->SetXY(85, 158);
$pdf->Write(2, $pincode);*/

$pdf->SetXY(85, 150);
$pdf->Write(2, $gender);

$pdf->SetXY(85, 162);
$pdf->Write(2, $nationality);

$pdf->SetXY(15, 179);
$pdf->MultiCell(140, 10, $addressP);

$pdf->SetXY(85, 218);
$pdf->Write(2, $bg);

$pdf->SetXY(85, 231);
$pdf->Write(2, $aadhar);

$pdf->SetXY(85, 245);
$pdf->Write(2, $health);
	
$pageNo = 2;
$tplIdx = $pdf->importPage($pageNo);
$pdf->AddPage();
$pdf->useTemplate($tplIdx, 0, 0);


$pdf->SetXY(75, 46);
//$pdf->Write(2, $fname);
$pdf->MultiCell(50, 5, $fname);

$pdf->SetXY(135, 46);
//$pdf->Write(2, $mname);
$pdf->MultiCell(50, 5, $mname);

$pdf->SetXY(75, 95);
$pdf->Write(2, $contact);

$pdf->SetXY(135, 95);
$pdf->Write(2, $contact1);

$pdf->SetXY(75, 108);
$pdf->Write(2, $email);


$pdf->SetXY(75, 125);
$pdf->Write(2, $fincome);

$pdf->SetXY(135, 125);
$pdf->Write(2, $mincome);


$pdf->SetXY(75, 150);
$pdf->Write(2, $sib1);

$pdf->SetXY(75, 162);
$pdf->Write(2, $sib2);


$pdf->SetXY(135, 150);
$pdf->Write(2, $sibclass1);

$pdf->SetXY(135, 162);
$pdf->Write(2, $sibclass2);


$pdf->SetXY(75, 180);
$pdf->Write(2, $religion);

$pdf->SetXY(75, 195);
$pdf->Write(2, $community);

$pdf->SetXY(75, 212);
$pdf->Write(2, $alumni);

$pdf->SetXY(75, 258);
$pdf->Write(2, $aluNo);

$pdf->SetXY(115, 223);
$pdf->Write(2, $yadno);

$pdf->SetXY(115, 229);
$pdf->Write(2, $ycom);

$pdf->SetXY(170, 234);
$pdf->Write(2, $NoYear);


$pdf->SetXY(75, 61);
$pdf->SetFont('Times', '', 9);
$pdf->Write(2, $fquali);

$pdf->SetXY(135, 61);
$pdf->Write(2, $mquali);


$pdf->SetXY(75, 70);
$pdf->MultiCell(50, 3, $foccdetails);


$pdf->SetXY(135, 70);
$pdf->MultiCell(50, 3, $moccdetails);

/*
$pageNo = 3;
$tplIdx = $pdf->importPage($pageNo);
$pdf->AddPage();
$pdf->useTemplate($tplIdx, 0, 0);


$obj_currency = new Currency();
$amount = number_format( $totAmount, 2 );
$amountinWords	=	"".$obj_currency->get_bd_amount_in_text($totAmount) ." only" ;

$pdf->SetXY(10, 119.5);
$pdf->MultiCell(75, 7, $amountinWords);


*/
$pdfName	=	"Application.pdf";
$pdf->Output($pdfName, 'I');

} catch (Exception $e) {
	echo "ERROR : " .$e->getMessage();
}

?>

