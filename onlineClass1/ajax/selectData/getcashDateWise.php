<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);

$dateFrom	=	date("Y-m-d", strtotime($data['dateFrom']));
$dateTo		=	date("Y-m-d", strtotime($data['dateTo']));
$yearId	    =	$_SESSION['YEAR_ID'];

$sqlFeeHistory	=	"SELECT * FROM `cash_voucher` WHERE `date` BETWEEN '".$dateFrom."' AND '".$dateTo."' AND Year_Id = '".$yearId."' ORDER BY name , id ASC " ;
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;

$arr	=	array();
if( $cntFeeHistory > 0 ) {

	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arr[]	=	$row;
	}

}

$json_response = json_encode($arr);
echo $json_response;
exit;



?>