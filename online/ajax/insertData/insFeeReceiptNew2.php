<?php

session_start();
unset($_SESSION["payDetails"]);
unset($_SESSION['razorpay_order_id']);
// unset order id;
$postData = json_decode(file_get_contents('php://input'), true);
$_SESSION['payDetails'] = $postData;
$data = $_SESSION['payDetails'];
/*
$amt1 = 0;
$amt2 = 0;
$amt3 = 0;
$amt4 = 0;
$amt5 = 0;
$amt6 = 0;

$amt1=$data['stuFeeDetails'][0]['FAsofBalance'];
$amt2=$data['stuFeeDetails'][1]['FAsofBalance'];
$amt3=$data['stuFeeDetails'][2]['FAsofBalance'];
$amt4=$data['stuFeeDetails'][3]['FAsofBalance'];
$amt5=$data['stuFeeDetails'][4]['FAsofBalance'];
$amt6=$data['stuFeeDetails'][5]['FAsofBalance'];*/

$json_response = json_encode($data);
echo $json_response;
?>