<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data		=	json_decode(file_get_contents('php://input'), true);

$yearId		=	$_SESSION['YEAR_ID'];

$feeGroupId	=	$data['feeGroup'];

$sqlFeeStructure	=	"SELECT T1.FeeGrpMapId, T2.FeeHeadId,T1.FeeGrpID, T2.feehead, T2.feetype, T1.feeAmount,T1.start_date,T1.due_date, T1.status FROM feegroupmapping T1, feeheads T2 WHERE T1.FeeHeadId = T2.feeheadId AND T2.feeheadstatus = 1 AND T1.FeeGrpID = '".$feeGroupId."' AND T1.Year_Id ='".$yearId."' ";
$exeFeeStructure	=	$mysqli->query($sqlFeeStructure);
$cntFeeStructure	=	$exeFeeStructure->num_rows;

$arr	=	array();
if( $cntFeeStructure > 0 ) {
	while( $row = $exeFeeStructure->fetch_assoc() ) {		
		$arr[]	=	$row;
	}
}

$json_response = json_encode($arr);
// # Return the response
echo $json_response;

exit;



?>