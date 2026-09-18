<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');


$postData = json_decode(file_get_contents('php://input'), true);


if( !empty($postData) ) {
	foreach( $postData['uRepceiptDetails'] as $key => $val ) {
		$upTransId	=	$val['FeeTransID'];
		$upAmount	=	$val['FeeTransAmount'];
				
		$sqlUpdFeeTrans	=	"UPDATE `fee_transanction` SET `Amount` = '".$upAmount."' WHERE `transId` = '".$upTransId."' " ;
		$exeUpdFeeTrans	=	$mysqli->query($sqlUpdFeeTrans);
		
		$arr['success']	+=	$mysqli->affected_rows;
	}
}



$json_response = json_encode($arr);
echo $json_response;
	
?>