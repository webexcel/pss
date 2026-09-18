<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if(!empty($data)) {
	$Gid	=	trim($data['uStudent']['eGid']);
	$Gname	=	trim($data['uStudent']['eGroup']);
	
	$sqlUpdAcademic	=	"UPDATE `feegroup` SET `feeGroup` = '".$Gname."' WHERE `feeGroupId` = '".$Gid."' ";		
	$exeUpdAcademic	=	$mysqli->query($sqlUpdAcademic);	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>