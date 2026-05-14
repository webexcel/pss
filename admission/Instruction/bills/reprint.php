<?php
try {

require_once('../configi.php');
require_once("functions.php");
require_once("currency.php");

error_reporting(1);


$fno	=	trim($_POST['fno']);
$dob1	=	trim($_POST['dob']);
$dob    =   date("Y-m-d", strtotime($dob1));


$sqlFeeHistory	=	"SELECT * FROM `application` WHERE `fno` = '".$fno."' and dob = '".$dob."'";
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
$maxdate1 = '31.05.2025';
$maxdate =  date("d.m.y", strtotime($maxdate1));
$today = new Datetime($maxdate);
$diff = $today->diff($bday);
$year = $diff->y;
$month = $diff->m;

$mt = $row['mt'];
$bg = $row['bg'];
$emis = $row['emis'];
$II_L = $row['II_L'];
$III_L = $row['III_L'];
$aadhar = $row['aadhar'];
$gender = $row['gender'];
$nationality = $row['nationality'];
$religion = $row['religion'];
$community = $row['community'];
$addressP1 = $row['addressP'];
$addressP = $addressP1;
$health = $row['health'];
$contact = $row['contact'];
$contact1 = $row['contact1'];
$email = strtolower($row['email']);
$schoolName = $row['schoolName']; 


$fname = $row['fname'];
$fquali = $row['fquali'];
$gender = $row['gender'];
$focc = $row['focc'];
$fincome = $row['fincome'];
//$foccdetails = $row['foccdetails'];
//$foccdetails = $focc.','.$foccdetails1;

$mname = $row['mname'];
$mquali = $row['mquali'];
$mocc = $row['mocc'];
$mincome = $row['mincome'];
//$moccdetails = $row['moccdetails'];
//$moccdetails = $mocc.','.$moccdetails1;

$distance = $row['distance'];

$sname1 = $row['sname1'];
if($sname1 != ''){$sib1 = $sname1;}else{$sib1 = '-';}
$sibadno1 = $row['adno1'];


$sname2 = $row['sname2'];
if($sname2 != ''){$sib2 = $sname2;}else{$sib2 = '-';}
$sibadno2 = $row['adno2'];


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
	$aluNo1 = 'NO';
}

$yadno = $row['yadno'];
$yclass = $row['yclass'];
$yadnoclass = $yadno.'-'.$yclass;

$ycom = $row['ycom'];
$cclass = $row['cclass'];
$yadnoclass1 = $ycom.'-'.$cclass;

$alumni = $row['alumni'];
$int_course = $row['int_course'];

$NoYear = $ycom.'-'.$yadno;

/*
define('FPDF_FONTPATH','FPDF-1.8.1/font');
require_once('FPDF-1.8.1/fpdf.php');
require_once('FPDI-1.6.2/fpdi.php');
*/
if($applied == 'IX'){
/*	
$pdf = new FPDI("P");
$pageCount = $pdf->setSourceFile("IX.pdf"); 	
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
$pageCount = $pdf->setSourceFile("IX.pdf"); 	

$pageNo = 1;
$tplIdx = $pdf->importPage($pageNo);
$pdf->useTemplate($tplIdx, 0, 0);

$pdf->SetXY(173, 100);
$pdf->Write(2, $fno);

$pdf->SetXY(85, 102);
$pdf->Write(2, $applied);

$pdf->SetXY(85, 117);
$pdf->Write(2, $name);

$pdf->SetXY(85, 127);
$pdf->Write(2, $dob);

$pdf->SetXY(85, 140);
$pdf->Write(2, $gender);

$pdf->SetXY(85, 152);
$pdf->Write(2, $nationality);

$pdf->SetXY(15, 172);
$pdf->MultiCell(160, 5, $addressP);

$pdf->SetXY(82, 194);
$pdf->Write(2, $bg);

$pdf->SetXY(82, 205);
$pdf->Write(2, $aadhar);

$pdf->SetXY(82, 217);
$pdf->Write(2, $emis);

$pdf->SetXY(82, 226);
$pdf->Write(2, $mt);

$pdf->SetXY(82, 236);
$pdf->Write(2, $II_L);

$pdf->SetXY(82, 246);
$pdf->MultiCell(110, 5, $schoolName);
//$pdf->Write(2, $schoolName);

$pdf->SetXY(82, 261);
$pdf->Write(2, $int_course);

$pageNo = 2;
$tplIdx = $pdf->importPage($pageNo);
$pdf->AddPage();
$pdf->useTemplate($tplIdx, 0, 0);

//$pdf->AddPage();
//$pdf->useTemplate($tplIdx, null, null, 0, 0, true);

$pdf->SetXY(75, 46);
$pdf->MultiCell(50, 5, $fname);

$pdf->SetXY(136, 46);
$pdf->MultiCell(50, 5, $mname);



$pdf->SetXY(75, 96);
$pdf->Write(2, $contact);

$pdf->SetXY(136, 96);
$pdf->Write(2, $contact1);

$pdf->SetXY(75, 108);
$pdf->Write(2, $email);

$pdf->SetXY(75, 125);
$pdf->Write(2, $fincome);

$pdf->SetXY(136, 125);
$pdf->Write(2, $mincome);

$pdf->SetXY(75, 150);
$pdf->Write(2, $sib1);

$pdf->SetXY(75, 160);
$pdf->Write(2, $sib2);

$pdf->SetXY(136, 150);
$pdf->Write(2, $sibclass1);

$pdf->SetXY(136, 160);
$pdf->Write(2, $sibclass2);

$pdf->SetXY(75, 180);
$pdf->Write(2, $religion);

$pdf->SetXY(75, 193);
$pdf->Write(2, $community);

$pdf->SetXY(74, 206);
$pdf->Write(2, $aluNo);

$pdf->SetXY(74, 206);
$pdf->Write(2, $aluNo1);
/*
$pdf->SetXY(110, 177);
$pdf->Write(2, $aname);
*/
$pdf->SetXY(115, 217);
$pdf->Write(2, $yadno);

$pdf->SetXY(115, 223);
$pdf->Write(2, $ycom);

$pdf->SetXY(165, 217);
$pdf->Write(2, $yclass);

$pdf->SetXY(165, 223);
$pdf->Write(2, $cclass);


$pdf->SetXY(75, 61);
$pdf->SetFont('Times', '', 9);
$pdf->Write(2, $fquali);

$pdf->SetXY(136, 61);
$pdf->Write(2, $mquali);

$pdf->SetXY(75, 71);
//$pdf->Write(2, $foccdetails);
$pdf->MultiCell(50, 3, $foccdetails);

$pdf->SetXY(136, 71);
//$pdf->Write(2, $moccdetails);
$pdf->MultiCell(50, 3, $moccdetails);

} 
else
{
	
require __DIR__ . '/vendor/autoload.php';
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage('P');
$pdf->SetFont('Times', '', '12');
$pageCount = $pdf->setSourceFile("II.pdf"); 	

$pageNo = 1;
$tplIdx = $pdf->importPage($pageNo);
$pdf->useTemplate($tplIdx, 0, 0);

$pdf->SetXY(179, 110);
$pdf->Write(2, $fno);

$pdf->SetXY(85, 107);
$pdf->Write(2, $applied);

$pdf->SetXY(85, 122);
$pdf->Write(2, $name);

$pdf->SetXY(85, 135);
$pdf->Write(2, $dob);

$pdf->SetXY(85, 145);
$pdf->Write(2, $gender);

$pdf->SetXY(85, 157);
$pdf->Write(2, $nationality);

$pdf->SetXY(15, 173);
$pdf->MultiCell(160, 11, $addressP);

$pdf->SetXY(80, 199);
$pdf->Write(2, $bg);

$pdf->SetXY(80, 212);
$pdf->Write(2, $aadhar);

$pdf->SetXY(80, 224);
$pdf->Write(2, $emis);

$pdf->SetXY(80, 237);
$pdf->Write(2, $mt);

$pdf->SetXY(80, 247);
$pdf->Write(2, $II_L);

$pdf->SetXY(80, 258);
$pdf->Write(2, $III_L);

$pdf->SetXY(80, 268);
$pdf->MultiCell(110, 5, $schoolName);

//$pdf->SetXY(80, 262);
//$pdf->MultiCell(95, 5, $schoolName);

$pageNo = 2;
$tplIdx = $pdf->importPage($pageNo);
$pdf->AddPage();
$pdf->useTemplate($tplIdx, 0, 0);


$pdf->SetXY(75, 46);
$pdf->MultiCell(50, 5, $fname);

$pdf->SetXY(136, 46);
$pdf->MultiCell(50, 5, $mname);

$pdf->SetXY(75, 96);
$pdf->Write(2, $contact);

$pdf->SetXY(136, 96);
$pdf->Write(2, $contact1);

$pdf->SetXY(75, 108);
$pdf->Write(2, $email);

$pdf->SetXY(75, 125);
$pdf->Write(2, $fincome);

$pdf->SetXY(136, 125);
$pdf->Write(2, $mincome);

$pdf->SetXY(75, 150);
$pdf->Write(2, $sib1);

$pdf->SetXY(75, 160);
$pdf->Write(2, $sib2);

$pdf->SetXY(136, 150);
$pdf->Write(2, $sibclass1);

$pdf->SetXY(136, 160);
$pdf->Write(2, $sibclass2);

$pdf->SetXY(75, 180);
$pdf->Write(2, $religion);

$pdf->SetXY(75, 193);
$pdf->Write(2, $community);

$pdf->SetXY(74, 206);
$pdf->Write(2, $aluNo);

$pdf->SetXY(74, 207);
$pdf->Write(2, $aluNo1);
/*
$pdf->SetXY(110, 177);
$pdf->Write(2, $aname);
*/
$pdf->SetXY(115, 217);
$pdf->Write(2, $yadno);

$pdf->SetXY(115, 223);
$pdf->Write(2, $ycom);

$pdf->SetXY(165, 217);
$pdf->Write(2, $yclass);

$pdf->SetXY(165, 223);
$pdf->Write(2, $cclass);

$pdf->SetXY(75, 61);
$pdf->SetFont('Times', '', 9);
$pdf->Write(2, $fquali);

$pdf->SetXY(136, 61);
$pdf->Write(2, $mquali);

$pdf->SetXY(75, 71);
$pdf->MultiCell(50, 3, $foccdetails);

$pdf->SetXY(136, 71);
$pdf->MultiCell(50, 3, $moccdetails);

}

/*

$obj_currency = new Currency();
$amount = number_format( $totAmount, 2 );
$amountinWords	=	"             ".$obj_currency->get_bd_amount_in_text($totAmount) ." only" ;

$pdf->SetXY(10, 119.5);
$pdf->MultiCell(75, 7, $amountinWords);


*/
$pdfName	=	"Application.pdf";
$pdf->Output($pdfName, 'I');

} catch (Exception $e) {
	echo "ERROR : " .$e->getMessage();
}


?>

