<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);
$yearId		=	$_SESSION['YEAR_ID'];

$sqlFeeGroup	=	"SELECT `feeGroupId` AS FEE_GROUP_ID, `feeGroup` AS FEE_GROUP FROM `feegroup` WHERE `feeGroupStatus` = 1  and `Year_Id` = '".$yearId."'";
//$sqlFeeGroup	=	"SELECT `feeGroupId` AS FEE_GROUP_ID, `feeGroup` AS FEE_GROUP FROM `feegroup` WHERE `feeGroupStatus` = 1";

//echo "SQL : " . $sqlFeeHeads . "<br />";

$exeFeeGroup	=	$mysqli->query($sqlFeeGroup);
$cntFeeGroup	=	$exeFeeGroup->num_rows;

$arr	=	array();
if( $cntFeeGroup > 0 ) {

	while( $row = $exeFeeGroup->fetch_assoc() ) {		
		$arr[]	=	$row;
	}

}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>