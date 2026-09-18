<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();
$data		=	json_decode(file_get_contents('php://input'), true);
$academicId	=	$data['academic'];
$sql	=	"SELECT * FROM `tbl_academicyear` WHERE `YearId` = '".$academicId."' ";
$exe	=	$mysqli->query($sql);
$cnt	=	$exe->num_rows;
$arr	=	array();

if( $cnt > 0 ) {
	while( $row = $exe->fetch_assoc() ) {
		
		$temp['AcademicYear']	=	$row['AcademicYear'];	
		$_SESSION['YEAR_ID'] = $row['YearId'];
		$_SESSION['Sdate'] = $row['Sdate'];
		$_SESSION['Edate'] = $row['Edate'];
	}
}
$json_response = json_encode($temp);
echo $json_response;
exit;



?>