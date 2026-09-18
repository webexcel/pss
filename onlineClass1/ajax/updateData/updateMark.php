<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');


$_POST = json_decode(file_get_contents('php://input'), true);

echo "<pre>";
print_r($_POST);




exit;


$id			=	trim($_POST['id']);
$adno		=	trim($_POST['adno']);
$modeOfExam	=	trim($_POST['moe']);
$tamil		=	trim($_POST['firstLanguage']);
$english	=	trim($_POST['secondLanguage']);
$maths		=	trim($_POST['maths']);
$science	=	trim($_POST['science']);
$socialScience = trim($_POST['socialScience']);

if( $id	!= '' ) {
	$sqlMarkUpdate	=	"UPDATE `tbl_marks` SET `ADMISSION_ID` = '".$adno."', `modeOfExam` = '".$modeOfExam."', `firstLanguage` = '".$tamil."', `secondLanguage` = '".$english."', `maths` = '".$maths."', `science` = '".$science."', `socialScience` = '".$socialScience."' WHERE `markID` = '".$id."'";
	$exeMarkUpdate	=	mysqli_query($con, $sqlMarkUpdate) or die(mysqli_error());
	$affRows		=	mysqli_affected_rows($con);
} else {
	$sqlMarkUpdate	=	"INSERT INTO `tbl_marks` (`ADMISSION_ID`, `modeOfExam`, `firstLanguage`, `secondLanguage`, `maths`, `science`, `socialScience`) VALUES ('".$adno."', '".$modeOfExam."', '".$tamil."', '".$english."', '".$maths."', '".$science."', '".$socialScience."')"; 
	$exeMarkUpdate	=	mysqli_query($con, $sqlMarkUpdate) or die(mysqli_error());
	$arow['markID']	=	mysqli_insert_id($con);
	$affRows		=	$arow;
}


 



echo json_encode($affRows);
exit;


foreach ($_POST as $key => $value ) {
	$data = explode('|', $value);
	$columnName = $key;
	$valuq = $value;
}

	$ADMISSION_ID = $_POST['ADMISSION_ID'];
	$abslist = "UPDATE `student_info1` SET $columnName ='$valuq' WHERE `ADMISSION_ID`='$ADMISSION_ID'";	
	$abslistexe = mysql_query($abslist);
	while($row = mysql_fetch_array($abslistexe)){
		$data = $row;
	}

	print json_encode($data);
	?>