<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

session_start();

$data	=	json_decode(file_get_contents('php://input'), true);
$yearId		=	$_SESSION['YEAR_ID'];
$fgid	=	($_GET['fgid']) ? $_GET['fgid'] : '';

if($fgid != "") {
	//$sqlFeeHead	=	"SELECT `feeheadId`, `feehead`, `feetype`, `interval` FROM `feeheads` WHERE `feeheadstatus` = 1 ";
	$sqlFeeHead	=	" SELECT * FROM feeheads WHERE feeheadId NOT IN(SELECT T2.FeeHeadId FROM feegroupmapping T1, feeheads T2 WHERE T1.FeeHeadId = 
	T2.feeheadId AND T2.feeheadstatus = 1 AND T1.Year_Id = '".$yearId."' AND T2.Year_Id = '".$yearId."' AND T1.FeeGrpID = '".$fgid."') AND Year_Id = '".$yearId."' ";
	
	//echo "SQL : " . $sqlFeeHeads . "<br />";
	
	$exeFeeHead	=	$mysqli->query($sqlFeeHead);
	$cntFeeHead	=	$exeFeeHead->num_rows;
	
	$arr	=	array();
	if( $cntFeeHead > 0 ) {
	
		while( $row = $exeFeeHead->fetch_assoc() ) {		
			$arr[]	=	$row;
		}
	
	}
} else {
	$arr[] = array('error' => 'true', 'message' => 'failled');
}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>