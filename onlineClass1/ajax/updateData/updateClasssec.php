<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if(!empty($data)) {
	$Cid		=	trim($data['uStudent']['eCid']);
	$eClass		=	trim($data['uStudent']['eClass']);
	$eSec		=	trim($data['uStudent']['eSec']);
	$eAdnosuff	=	trim($data['uStudent']['eAdnosuff']);
	
	$sqlUpdAcademic	=	"UPDATE `tbl_class` SET `Standard` = '".$eClass."',`Section` = '".$eSec."' ,`AdnoSuffix` = '".$eAdnosuff."' WHERE `CLASS_ID` = '".$Cid."' ";		
	$exeUpdAcademic	=	$mysqli->query($sqlUpdAcademic);	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>