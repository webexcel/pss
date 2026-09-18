<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
require_once("../function.php");
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);

$yearId	=	$_SESSION['YEAR_ID'];
$cnt 	=	count($data);

	if( $cnt > 0 ) {
		$AddAmt	  		=	trim($data['Amount']);
		$feeGroupMapId	=	trim($data['id']);
		$feeheadid		=	trim($data['feeheadId']);
		$feeheadid		=	trim($data['feeheadId']);
		$feegroupid	    =	trim($data['feegroupId']);
		$fBalAmount	    =	trim($data['feeamount']);		
		$Upfees         = 	$fBalAmount+$AddAmt;
		
		
		
		$sqlUpdFeeStru	=	" UPDATE feegroupmapping SET feeAmount = '".$Upfees."' WHERE FeeGrpMapId = '".$feeGroupMapId."' and FeeHeadId = '".$feeheadid."' and 	FeeGrpID = '".$feegroupid."' " ;			
		$exeUpdFeeStru	=	$mysqli->query($sqlUpdFeeStru);
		
				
		$sqlUpdFeeStru1	=	" UPDATE feestatus SET totAmount = '".$Upfees."', Balance_Amount = Balance_Amount+'".$AddAmt."' WHERE FeeGrpMapId = '".$feeGroupMapId."' and Fee_Headid = '".$feeheadid."' and Paid_Type = '".$feegroupid."' " ;		
		$exeUpdFeeStru1	=	$mysqli->query($sqlUpdFeeStru1);
		if($exeUpdFeeStru && $exeUpdFeeStru1) {
			$arr	=	array('error' => false, 'message' => 'success');
		} else {
			$arr	=	array('error' => true, 'message' => 'failled');
		}
	} else {
		$arr	=	array('error' => true, 'message' => 'failled1');
	}

$json_response = json_encode($arr);
echo $json_response;
?>	