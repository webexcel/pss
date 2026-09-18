<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if(!empty($data)) {
	$Lid	=	trim($data['uStudent']['eLid']);
	$Lname	=	trim($data['uStudent']['elang']);
	
	$sqlUpdAcademic	=	"UPDATE `tbl_2ndlanguage` SET `langName` = '".$Lname."' WHERE `langId` = '".$Lid."' ";		
	$exeUpdAcademic	=	$mysqli->query($sqlUpdAcademic);	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>