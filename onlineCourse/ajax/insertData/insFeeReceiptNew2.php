<?php
/*
$dbconnect = new  mysqli('localhost','main','jayam','sbcbse'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}*/ 
session_start();
unset($_SESSION["payDetails"]);
unset($_SESSION['razorpay_order_id']);

$postData = json_decode(file_get_contents('php://input'), true);
$_SESSION['payDetails'] = $postData;
$data = $_SESSION['payDetails'];

$json_response = json_encode($data);
//echo $json_response;
?>