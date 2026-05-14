<?php
try {

require_once('configi.php');
require_once("functions.php");
require_once("currency.php");

error_reporting(1);


$fno	=	trim($_POST['fno']);
$dob1	=	trim($_POST['dob']);
$dob    =   date("Y-m-d", strtotime($dob1));


$sqlFeeHistory	=	"SELECT * FROM `application_xi` WHERE `fno` = '".$fno."' and dob = '".$dob."'";


$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$row = $exeFeeHistory->fetch_assoc();
$fno = $row['fno'];
$name = $row['name'];
$dob1 = $row['dob'];
$dob =  date("d-m-Y", strtotime($dob1));
$gender = $row['gender'];
$community = $row['community'];
$addressP = $row['addressP'];
$basicstudy = $row['basicstudy'];
$schoolName = $row['schoolName']; 
$contact = $row['contact'];
$contact1 = $row['contact1'];
$email = $row['email'];
$emis = $row['emis'];
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
$adno1 = $row['adno1'];
$class1 = $row['class1'];
$sec1 = $row['sec1'];
$sibclass1 = 'Adno : '.$adno1.' ( '.$class1.'-'.$sec1.' )';


if($adno1 != ''){
	$aluNo = $sibclass1;
}else{
	$aluNo = '';
}
$sub1 = $row['first'];
$sub2 = $row['second'];
$sub3 = $row['third'];
$sub4 = $row['fourth'];




require __DIR__ . '/vendor/autoload.php';
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage('P');
$pdf->SetFont('Times', '', '12');
$pageCount = $pdf->setSourceFile("XI.pdf"); 	
$pageNo = 1;
$tplIdx = $pdf->importPage($pageNo);
$pdf->useTemplate($tplIdx, 0,0);

$pdf->SetXY(158, 55);
$pdf->Write(2, $fno);

$pdf->SetXY(88, 85);
$pdf->Write(2, $name);

$pdf->SetXY(88, 105);
$pdf->Write(2, $dob);

$pdf->SetXY(88, 128);
$pdf->Write(2, $gender);	

$pdf->SetXY(88, 138);
$pdf->MultiCell(85, 7, $addressP);

$pdf->SetXY(85, 175);
$pdf->Write(2, $aluNo);

$pdf->SetXY(88, 196);
$pdf->MultiCell(50, 5, $fname);

$pdf->SetXY(140, 196);
$pdf->MultiCell(50, 5, $mname);

$pdf->SetXY(88, 211);
$pdf->Write(2, $fquali);

$pdf->SetXY(140, 211);
$pdf->Write(2, $mquali);

$pdf->SetXY(88, 217);
$pdf->MultiCell(50, 7, $foccdetails);


$pdf->SetXY(140, 217);
$pdf->MultiCell(50, 7, $moccdetails);

$pdf->SetXY(88, 241);
$pdf->Write(2, $contact);

$pdf->SetXY(140, 241);
$pdf->Write(2, $contact1);

$pdf->SetXY(88, 255);
$pdf->Write(2, $email);

$pdf->SetXY(88, 270);
$pdf->Write(2, $fincome);

$pdf->SetXY(140, 270);
$pdf->Write(2, $mincome);

	
$pageNo = 2;
$tplIdx = $pdf->importPage($pageNo);
$pdf->AddPage();
$pdf->useTemplate($tplIdx, null, null, 0, 0, true);


$pdf->SetXY(88, 22);
$pdf->Write(2, $community);

$pdf->SetXY(88, 35);
$pdf->Write(2, $emis);

$pdf->SetXY(88, 52);
$pdf->Write(2, $basicstudy);

$pdf->SetXY(88, 75);
$pdf->MultiCell(85, 6, $schoolName);


$pdf->SetXY(55, 114);
$pdf->Write(2, $sub1);

$pdf->SetXY(55, 126);
$pdf->Write(2, $sub2);

$pdf->SetXY(55, 136);
$pdf->Write(2, $sub3);

$pdf->SetXY(55, 146);
$pdf->Write(2, $sub4);
$pdfName	=	"Application_XI.pdf";
$pdf->Output($pdfName, 'I');

} catch (Exception $e) {
	echo "ERROR : " .$e->getMessage();
}

?>

