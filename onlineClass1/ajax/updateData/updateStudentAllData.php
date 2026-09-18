
<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if( !empty($data) ) {
	$adno	=	trim($data['uStudent']['eOAdno']);
	$emisno	=	trim($data['uStudent']['eEmisNo']);
	$name	=	trim($data['uStudent']['eName']);
	$fname	=	trim($data['uStudent']['eFatherName']);
	
	
	$sqlSelOthers	=	"SELECT * FROM `stu_others` WHERE `ADMISSION_ID` = '".$adno."' ";
	$exeSelOthers	=	$mysqli->query($sqlSelOthers);
	if($exeSelOthers->num_rows > 0) {
		$sqlUpdOthers	=	"UPDATE `stu_others` SET `EMISNumber` = '".$emisno."' WHERE `ADMISSION_ID` = '".$adno."' ";
		$sqlUpdStud		=	"UPDATE `student_info1` SET `NAME` = '".$name."',`FATHER_NAME` = '".$fname."' WHERE `ADMISSION_ID` = '".$adno."' ";
		$exeUpdOthers	=	$mysqli->query($sqlUpdOthers);
		$exeUpdStud	=	$mysqli->query($sqlUpdStud);
	} else {
		$sqlInsOthers	=	"INSERT `stu_others`(ADMISSION_ID, `EMISNumber`) VALUES('".$adno."', '".$emisno."') ";
		$exeInsOthers	=	$mysqli->query($sqlInsOthers);
	}
	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}



$json_response = json_encode($arr);
echo $json_response;
	
?>