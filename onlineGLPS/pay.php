<?php
require('config.php');
require('configi.php');
//require('razorpay-php/Razorpay.php');
require __DIR__ . '/vendor/autoload.php';
session_start();
////////////////////////////////////////////
	$postData = $_SESSION['payDetails'];
	
	$postData1 = json_encode($postData);
	$data	=	array_shift($postData['stuFeeDetails1']);
	//print_r($data);
	//exit;
	$ADNO		=	$data['ADNO']; 
	$classsec	=	$data['classsec']; 
	$ASamount	=   3000;// change here
	$Year_Id    =   '6';
	$name   	=   $data['name'];
	$studentInfo =  $ADNO.'-'.$Year_Id.'-'.$classsec;


use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => $data['ADNO'],
    'amount'          => $ASamount * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);
    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}


$sql = "INSERT INTO `razorpay_coach` (`order_id`, `adno`, `mobile`, `amount`, `Year_Id`, `start_time`,`paydetails`) VALUES 
('".$razorpayOrderId."', '".$data['ADNO']."', '124', '".$ASamount."', '".$Year_Id ."', now(),'".$postData1."')";
if ($dbconnect->query($sql) === TRUE) {
  $last_id = mysqli_insert_id($dbconnect);
			$_SESSION['razorid'] = $last_id;
} else {
  echo "Error: " . $sql . "<br>" . $dbconnect->error;
  die('Something went wrong!');
}
$dbconnect->close();
$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "P.S.Senior Secondary School",
    "description"       => "P.S.Senior Secondary School",
    "image"             => "",
    "prefill"           => [
	  "YEARID"          => $Year_Id,
    "contact"           => "1234",
    ],
    "notes"             => [
    "address"           => $ADNO.'-'.$name.'-'.$Year_Id,
    "merchant_order_id" => $ADNO,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}
$json = json_encode($data);
require("checkout/manual.php");
?>
