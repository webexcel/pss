<?php

require_once('../../configi.php');
session_start();


$_POST	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	'6';
$adno = $_POST['adno'];

$query	=	" SELECT  `class` AS CLASS_SECTION, `name`, `adno`,`amount`  FROM `v_course` WHERE `adno` = '".$adno."' and `Year_Id` = '".$yearId."'";
$result	=	mysqli_query($dbconnect, $query);
$arr = array();


if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$arrFeeDetails = array();
		$sno++;
		$row['sno']			=	$sno;
		$arr['ADNO'] 		=	$row['adno'];
		$arr['NAME']		=	$row['name'];
		$arr['SECTION']		=	$row['CLASS_SECTION'];	
		$arr['amount']		=	$row['amount'];
	}
}

$sqlFeeHistory	=	"SELECT `description`,`pay_id`,date(`insDate`) as `insDate`, `amount` FROM `v_course` WHERE `adno` = '".$adno."'";
$exeFeeHistory	=	mysqli_query($dbconnect,$sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;
$t = 0;
if( $cntFeeHistory > 0 ) {
	$arrT2['TOT_HISTORY'] = array();
	while( $row1 = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHis = array();
		$arrFeeHis['sno']		= 	$t++;
		$arrFeeHis['date']		=	$row1['insDate'];		
		$arrFeeHis['pay_id']	=	$row1['pay_id'];
		$arrFeeHis['game']		=	$row1['description'];
		$arrFeeHis['amount']	=	$row1['amount'];
		$arrT2['TOT_HISTORY'] 	= 	$arrFeeHis;
	}
}

$arr	=	array_merge($arr, $arrT2);
$json_response = json_encode($arr);
echo $json_response;
exit;
	

?>