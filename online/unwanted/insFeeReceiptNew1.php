<?php
//require_once('../login/auth.php');
require_once('login/configi.php');
//require_once("function.php");

$postData = $_SESSION['payDetails'];
$cnt 	=	count($postData);
if( $cnt > 0 ) {
	$data	=	array_shift($postData['stuFeeDetails1']);
	$ADNO			=	$data['ADNO']; 
	$classId		=	$data['CLASS_ID']; 
	$YEAR_ID		=	'3';
	$PAYMENT_DATE	=	date('Y-m-d'); ////////
	$mobile			=	$_SESSION['mobile'];
	$receiptid 		= 	$_SESSION['razorid'];
	$fee_mode_ref	=	$_POST['razorpay_payment_id'];
	$sqlInsFeeReceipt	=	"INSERT INTO `fee_receipt` (`RECEIPT_NO`,`ADMISSION_ID`,`CLASS_ID`,`RECEIPT_DATE`, `FEE_MODE`, FEE_MODE_REF_NO,`YEAR_ID`) 
	VALUES ('".$receiptid."', '".$ADNO."', '".$classId."','".$PAYMENT_DATE."', 'Online', '".$fee_mode_ref."','1')";
	
	$exeInsFeeReceipt	=	$mysqli->query($sqlInsFeeReceipt);
	
	$receptId			=	$mysqli->insert_id;
	foreach ($postData['stuFeeDetails'] as $item) {
		$FHeadID		=	$item['FHeadID'];
		$FHead			=	$item['FEE_HEAD'];
		$FType			=	$item['FType'];
		$FPreBalance	=	$item['FPreBalance'];
		$FAsofBalance	=	$item['FAsofBalance'];
		$FSID			=	$item['FSID'];
			if( $FAsofBalance != '' && is_numeric($FAsofBalance) ) 	{		
				$sqlInsFeeRecDetails	=	"INSERT INTO `fee_transanction` (`RECEIPT_ID`, `feeHead`, `Amount`,`Year_Id`) VALUES ('".$receptId."', '".$FHeadID."', '".$FAsofBalance."','1') ";
				$exeInsFeeRecDetails	=	$mysqli->query($sqlInsFeeRecDetails);
				$arr['success']			=	$mysqli->affected_rows;
				if($FType == 'Annual' || $FType == 'PENDING') {	//	Should be maintain the feetype in db
					$remAmount		=	$FPreBalance - $FAsofBalance;
				}
				$sqlUpdFeesStatus	=	"UPDATE `feestatus` SET `Balance_Amount`= '".$remAmount."' WHERE `FSID` = '".$FSID."' AND `Year_Id` = '1' ";
				$exeUpdFeesStatus	=	$mysqli->query($sqlUpdFeesStatus);
				unset($_SESSION["payDetails"]);
			} else {
			}
	}
}
?>