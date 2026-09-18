<?php

require('configi.php');

$keyId = 'rzp_live_N1R53Ubks63NBg';
$keySecret = 'l2YzCaDJLfWECG5GyYX8cBJS';

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$api = new Api($keyId, $keySecret);

$query = "Select * from razorpay where status = 'START' and date(`start_time`) between '2026-06-01' and '2026-06-30' and `Year_Id` = '6'";
$res = $dbconnect->query($query);
if($res -> num_rows > 0){
while($row = mysqli_fetch_assoc($res)){
	$orderId 	= $row['order_id'];
	$ADNO 		= $row['adno'];
	$start_time1 	= $row['start_time'];
	$old_date_timestamp = strtotime($start_time1);
	$start_time = date('Y-m-d', $old_date_timestamp);
	$YEAR_ID 	= $row['Year_Id'];
	$razorpayPayId = $api->order->fetch($orderId)->payments();

	$razorpay_count	   = $razorpayPayId['count'];
	for($i = 0; $i < $razorpay_count; $i++ ){
	$razorpay_id 	   = $razorpayPayId['items'][$i]['id'];
	$razorpay_order_id = $razorpayPayId['items'][$i]['order_id'];
	$razorpay_captured = $razorpayPayId['items'][$i]['captured'];
	$razorpay_status = $razorpayPayId['items'][$i]['status']; 
		if($razorpay_status == 'captured' && $razorpay_captured == 1){
				$query1 = "UPDATE `razorpay` SET end_time = now(),`status` = 'COMPLETED',`payment_id`='".$razorpay_id."',`remarks` = 'Manual' WHERE order_id = '".$razorpay_order_id."'";
				if ($dbconnect->query($query1) === TRUE) {
					
					$sqlInsFee	=	"select * from razorpay where `order_id` = '".$razorpay_order_id."'";
					$exeInsFee	=	$dbconnect->query($sqlInsFee);
					
					if($exeInsFee -> num_rows > 0){
						$row = mysqli_fetch_assoc($exeInsFee);
						$postData  = $row['paydetails'];			
						$myArray 	= 	json_decode($postData, true);			
						$data		=	$myArray['stuFeeDetails1'];
						$classId	=	$data[0]['CLASS_ID'];
						$PAYMENT_DATE	= $start_time;
						//$RECPNO		=	"";
						
						$sql	=	"select * from `fee_receipt` where FEE_MODE_REF_NO  = '".$razorpay_id."'";
						$exe	=	$dbconnect->query($sql);
						$row1   =   mysqli_fetch_assoc($exe);
						$p_id   =   $row1['FEE_MODE_REF_NO'];
						
							if($p_id != $razorpay_id){
								
								$sqlsno	=	"select * from `tbl_serial_no` where `SerialCode` = 'Online-23'";
								$exesno	=	$dbconnect->query($sqlsno);
								$rows   = 	mysqli_fetch_assoc($exesno);
								$RECPNO = 	$rows['SerialNumber'];
							
								$sqlInsFeeReceipt	=	"INSERT INTO `fee_receipt` (`RECEIPT_NO`,`ADMISSION_ID`,`CLASS_ID`, `RECEIPT_DATE`,`FEE_MODE`, FEE_MODE_REF_NO,`YEAR_ID`) 
								VALUES ('".$RECPNO."','".$ADNO."', '".$classId."','".$PAYMENT_DATE."', 'Online', '".$razorpay_id."','".$YEAR_ID."')";
								$exeInsFeeReceipt	=	$dbconnect->query($sqlInsFeeReceipt);
								$receptId			=	$dbconnect->insert_id;
								
								if($exeInsFeeReceipt) {
									$nextReSerNum	=	$RECPNO + 1;
									$sqlUpSerialNo	=	"UPDATE `tbl_serial_no` SET `SerialNumber` = '".$nextReSerNum."' WHERE `SerialCode` = 'Online-23' ";
									$dbconnect->query($sqlUpSerialNo);
								}
								
								foreach ($myArray['stuFeeDetails'] as $item) {
									$FHeadID		=	$item['FHeadID'];
									$FAsofBalance	=	$item['FAsofBalance'];
									$FSID			=	$item['FSID'];

									if( $FAsofBalance != '' && is_numeric($FAsofBalance) ) 	{		
										$sqlInsFeeRecDetails	=	"INSERT INTO `fee_transanction` (`RECEIPT_ID`, `feeHead`, `Amount`,`Year_Id`) VALUES ('".$receptId."', '".$FHeadID."', '".$FAsofBalance."','".$YEAR_ID."') ";
										$exeInsFeeRecDetails	=	$dbconnect->query($sqlInsFeeRecDetails);
										$arr['success']			=	$dbconnect->affected_rows;
										
										$sqlUpdFeesStatus	=	"UPDATE `feestatus` SET `Balance_Amount`= '0' WHERE `FSID` = '".$FSID."' AND `Year_Id` = '".$YEAR_ID."' ";
										$exeUpdFeesStatus	=	$dbconnect->query($sqlUpdFeesStatus);
									} else {
										$arr['fail']	=	'0';
									}	
								}
							}
							else{
								echo "Payment already exist";
							}
					}else{
						echo "No reference Details";
					}
				}
				
			}else{
				$query1 = "UPDATE `razorpay` SET `status` = 'START' WHERE order_id = '".$orderId."'";
				if ($dbconnect->query($query1) === TRUE) {
				  echo "Your payment failed";
				}
			}
		}

	
}
}else{
	echo "No data found";
}

?>
