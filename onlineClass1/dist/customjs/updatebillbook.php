<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if(!empty($data)) {
	$bid		=	trim($data['uStudent']['eBno']);
	$bname		=	trim($data['uStudent']['eBname']);
	$btype		=	trim($data['uStudent']['eBtype']);
	
	$sqlUpdAcademic	=	"UPDATE `tbl_bill` SET `BillBookName` = '".$bname."',`SerialCode` = '".$btype."' WHERE `billBookId` = '".$bid."' ";		
	$exeUpdAcademic	=	$mysqli->query($sqlUpdAcademic);	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>