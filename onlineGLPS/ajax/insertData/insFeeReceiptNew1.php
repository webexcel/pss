<?php

define("DB_HOST", 'schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com');
define("DB_USER", 'main');
define("DB_PASS", 'P@mani4u');
define("DB_NAME", 'pssenior');
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
$mysqli -> set_charset("utf8");
//$sqlInsFee	=	"select * from razorpay_coach where `order_id` = 'order_RplbHO0KImL3Wg'";
$sqlInsFee	=	"select * from razorpay_coach where `order_id` = '".$_POST['razorpay_order_id']."'";
$exeInsFee	=	$mysqli->query($sqlInsFee);
$postData = '';

if ($exeInsFee->num_rows > 0) {
    $row      = $exeInsFee->fetch_assoc();
    $postData = $row['paydetails'];

    // For debugging only:
    // echo $postData;
}

// If nothing found or empty JSON
if (empty($postData)) {
    die('No paydetails found for this order_id');
}

// Decode JSON as array
$myArray = json_decode($postData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Invalid JSON in paydetails: ' . json_last_error_msg());
}

// Use the actual array to count
$data = isset($myArray['stuFeeDetails1']) && is_array($myArray['stuFeeDetails1'])
    ? $myArray['stuFeeDetails1']
    : [];

$cnt = count($data);
if( $cnt > 0 ) {

	$ADNO			=	$data[0]['ADNO'];
	$payment_id		=	$_POST['razorpay_payment_id'];//////// 
	$sql	=	"select * from `v_coachlist_glps` where pay_id  = '".$payment_id."'";
	$exe	=	$mysqli->query($sql);
	$row 	= 	mysqli_fetch_assoc($exe);
	$p_id 	= 	$row['pay_id'];
	
	if($p_id != $payment_id){	
		$sqlUpdate	= "UPDATE `v_coachlist_glps` SET `pay_id`= '".$payment_id."' WHERE `adno` = '".$ADNO."' and `status` = '0'";
		$exesqlUpdate	=	$mysqli->query($sqlUpdate);
	}
	else{
		echo "Payment already exist";
	}
	
}
?>