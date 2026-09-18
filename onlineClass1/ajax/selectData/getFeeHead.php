<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

session_start();
$data	=	json_decode(file_get_contents('php://input'), true);

$yearId		=	$_SESSION['YEAR_ID'];

$sqlFeeHeads	=	"SELECT `feeheadId` AS FEE_HEAD_ID, `feehead` AS FEE_HEAD FROM `feeheads` ";
/*$sqlFeeHeads	=	"SELECT T2.feeheadId AS FEE_HEAD_ID, SUM(T1.Amount) AS AMOUNT, T2.feeHead AS FEE_HEAD
FROM  fee_transanction T1 JOIN feeheads T2 where T1.feeHead = T2.feeheadId AND T1.Year_Id = '".$yearId."' GROUP by T1.feeHead";

*/
$exeFeeHeads	=	$mysqli->query($sqlFeeHeads);
$cntFeeHeads	=	$exeFeeHeads->num_rows;


$arr =	array();
if( $cntFeeHeads > 0 ) {

	while( $row = $exeFeeHeads->fetch_assoc() ) {		
		$arr[]	=	$row;
	}

}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>