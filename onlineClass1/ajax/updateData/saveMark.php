<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');


$_POST = json_decode(file_get_contents('php://input'), true);

$id			=	trim($_POST['markID']);
$adno		=	trim($_POST['ADMISSION_ID']);
$modeOfExam	=	trim($_POST['modeOfExam']);
$subject_id	=	trim($_POST['subject_id']);
$subject_name=	trim($_POST['subject_name']);
$mark		=	trim($_POST['mark']);


if( $id	!= '' ) {
	$sqlMarkUpdate	=	"UPDATE `tbl_marks1` SET `ADMISSION_ID` = '".$adno."', `modeOfExam` = '".$modeOfExam."', `subject_id` = '".$subject_id."', `subject_name` = '".$subject_name."', `mark` = '".$mark."'  WHERE `markID` = '".$id."'";
	$exeMarkUpdate	=	mysqli_query($con, $sqlMarkUpdate) or die(mysqli_error());
	$affRows		=	mysqli_affected_rows($con);
} else {
	$sqlMarkUpdate	=	"INSERT INTO `tbl_marks1` (`ADMISSION_ID`, `modeOfExam`, `subject_id`, `subject_name`, `mark`) VALUES ('".$adno."', '".$modeOfExam."', '".$subject_id."', '".$subject_name."', '".$mark."')"; 
	$exeMarkUpdate	=	mysqli_query($con, $sqlMarkUpdate) or die(mysqli_error());
	$arow['markID']	=	mysqli_insert_id($con);
	$affRows		=	$arow;
}


/*
$id			=	trim($_POST['markID']);
$adno		=	trim($_POST['ADMISSION_ID']);
$modeOfExam	=	trim($_POST['modeOfExam']);
$subject	=	trim($_POST['subject']);
$mark		=	trim($_POST['mark']);

if( $id	!= '' ) {
	$sqlMarkUpdate	=	"UPDATE `tbl_marks` SET `ADMISSION_ID` = '".$adno."', `modeOfExam` = '".$modeOfExam."', `$subject` = '".$mark."' WHERE `markID` = '".$id."'";
	$exeMarkUpdate	=	mysqli_query($con, $sqlMarkUpdate) or die(mysqli_error());
	$affRows		=	mysqli_affected_rows($con);
} else {
	$sqlMarkUpdate	=	"INSERT INTO `tbl_marks` (`ADMISSION_ID`, `modeOfExam`, `$subject`) VALUES ('".$adno."', '".$modeOfExam."', '".$mark."')"; 
	$exeMarkUpdate	=	mysqli_query($con, $sqlMarkUpdate) or die(mysqli_error());
	$arow['markID']	=	mysqli_insert_id($con);
	$affRows		=	$arow;
}
*/
echo json_encode($affRows);

?>