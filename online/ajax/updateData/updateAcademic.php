
<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if(!empty($data)) {
	$aid	=	trim($data['uStudent']['eid']);
	$ayear	=	trim($data['uStudent']['eYear']);
	
	$sqlUpdAcademic	=	"UPDATE `tbl_academicyear` SET `AcademicYear` = '".$ayear."' WHERE `YearId` = '".$aid."' ";		
	$exeUpdAcademic	=	$mysqli->query($sqlUpdAcademic);	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>