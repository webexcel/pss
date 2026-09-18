<?php

require_once('../../login/config-mysqli.php');
session_start();


$_POST	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	'5';
$adno = $_POST['adno'];

$query	=	" SELECT  `class` AS CLASS_SECTION, `name`, `adno`,`contact` FROM `v_coachlist` WHERE `adno` = '".$adno."' and `Year_Id` = '".$yearId."'";
$result	=	mysqli_query($con, $query);
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
		$arr['contact']		=	$row['contact'];	
	}
}

$sqlFeeHistory	=	"SELECT `sel_coaching`,`pay_id`,date(`insDate`) as `insDate` FROM `v_coachlist` WHERE `adno` = '".$adno."'";
$exeFeeHistory	=	mysqli_query($con,$sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;
$t = 0;
if( $cntFeeHistory > 0 ) {
	$arrT2['TOT_HISTORY'] = array();
	while( $row1 = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHis = array();
		$arrFeeHis['sno']		= 	$t++;
		$arrFeeHis['date']		=	$row1['insDate'];		
		$arrFeeHis['pay_id']	=	$row1['pay_id'];
		$arrFeeHis['game']		=	$row1['sel_coaching'];
		$arrFeeHis['amount']	=	3500;
		//$arr2[] = $arrFeeHis;
		$arrT2['TOT_HISTORY'] 	= 	$arrFeeHis;
	}
}
/*
foreach( $arr2 as $key => $value ) {
	$receiptid	=	$value['sno'];		
	$newArr['FEE_HISTORY'][$receiptid][] = $value;
}	*/

$arr	=	array_merge($arr, $arrT2);
//$arr	=	array_merge($arr, $newArr);
	
$json_response = json_encode($arr);
echo $json_response;
exit;
	

?>