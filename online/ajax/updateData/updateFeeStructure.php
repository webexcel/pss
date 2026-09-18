<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data = json_decode(file_get_contents('php://input'), true);

if( !empty($data) ) {
	$feeGroupMapId	=	trim($data['feeGroupMapId']);
	$feeAmount		=	trim($data['feeAmount']);
	
	$sqlUpdFeeStru	=	" UPDATE feegroupmapping SET feeAmount = '".$feeAmount."' WHERE FeeGrpMapId = '".$feeGroupMapId."' " ;
	$exeUpdFeeStru	=	$mysqli->query($sqlUpdFeeStru);
	
	if( $exeUpdFeeStru ) {
		$arr['error']	=	false;
		$arr['status']	=	"success";
	}	
}

$json_response = json_encode($arr);
echo $json_response;
	
?>