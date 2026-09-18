<?php
require_once('login/configi.php');

$sqlInsFee	=	"select * from razorpay_coach where `order_id` = '".$_POST['razorpay_order_id']."'";
$exeInsFee	=	$mysqli->query($sqlInsFee);
if($exeInsFee -> num_rows > 0)
{
	$row = mysqli_fetch_assoc($exeInsFee); 
	$postData  = $row['paydetails'];
}
$myArray = json_decode($postData, true);
$cnt 	=	count($postData);
if( $cnt > 0 ) {
	$data	=	$myArray['stuFeeDetails1'];
	$ADNO			=	$data[0]['ADNO'];
	$gametype		=	$data[0]['gametype'];
	$payment_id		=	$_POST['razorpay_payment_id'];//////// 

	$sql	=	"select * from `v_coachlist` where pay_id  = '".$payment_id."'";
	$exe	=	$mysqli->query($sql);
	$row = mysqli_fetch_assoc($exe);
	$p_id = $row['pay_id'];
	
	if($p_id != $payment_id){	
		$sqlUpdate	= "UPDATE `v_coachlist` SET sel_coaching = '".$gametype."', `pay_id`= '".$payment_id."' WHERE `adno` = '".$ADNO."' and `status` = '0'";
		$exesqlUpdate	=	$mysqli->query($sqlUpdate);
	}
	else{
		echo "Payment already exist";
	}

	
}
?>