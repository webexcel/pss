<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data		=	json_decode(file_get_contents('php://input'), true);
$adno 		= $data['adno'];
$classId	= $data['class_id'];
$yearId		= $_SESSION['YEAR_ID'];
//$sqlFeeStructure	=	"SELECT T1 .*, T2.feeAmount FROM feeheads T1, feegroupmapping T2 WHERE T1.feeheadId = T2.FeeHeadId AND T2.Year_Id = '".$yearId."' AND T2.FeeGrpID = (SELECT T3.feeGrpId FROM tbl_class T3 WHERE T3.CLASS_ID = '".$classId."') ";
$sqlFeeStructure	=	"SELECT T1 .*, T2.Balance_Amount FROM feeheads T1, feestatus T2 WHERE T1.feeheadId = T2.Fee_Headid AND T2.Year_Id = '".$yearId."' AND T2.Admission_Id = '".$adno."'";

//echo "SQL : " . $sqlFeeStructure . "<br />";

$exeFeeStructure	=	$mysqli->query($sqlFeeStructure);
$cntFeeStructure	=	$exeFeeStructure->num_rows;

$arr	=	array();
if( $cntFeeStructure > 0 ) {

	while( $row = $exeFeeStructure->fetch_assoc() ) {
		$arr1	=	array();
		///$arr1['amt'] += $row['feeAmount'];
		$arr[]	=	$row;
		
	}

}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>