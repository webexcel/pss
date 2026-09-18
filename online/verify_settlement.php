<?php

$servername = "localhost";
$username = "main";
$password = "P@mani4u";
$dbname = "pssenior";

$conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
	echo "Please Contact Admin <br>";
	die("Connection failed: " . $conn->connect_error);
}


$keyId = 'rzp_live_N1R53Ubks63NBg';
$keySecret = 'l2YzCaDJLfWECG5GyYX8cBJS';

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$smonth	=	9;
$api = new Api($keyId, $keySecret);
$fetchpayDetails = $api->settlement->settlementRecon(array('year' => 2023, 'month' => $smonth));

foreach($fetchpayDetails['items'] as $data){
	$entity_id = $data['entity_id'];
	$settled_at = $data['settled_at'];
	$sdate = date("Y-m-d", $settled_at);
	$settlement_id = $data['settlement_id'];
	$sql = "update  `razorpay` set `sett_date` = '".$sdate."',`sett_id` = '".$settlement_id ."' , `status` = 'COMPLETED' where payment_id = '".$entity_id."'";
	if ($conn->query($sql) === TRUE) {
		echo "SUCCESS";
	} else {
		echo "Failer";		
	} 
	$sql1 = "update `fee_receipt` set `settle_Date` = '".$sdate."',`settlement_Id` = '".$settlement_id ."' where `FEE_MODE_REF_NO` = '".$entity_id."'";
	$res = $conn->query($sql1);	
}


?>
