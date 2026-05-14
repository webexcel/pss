<?php
require_once('config.php');
require_once('configi.php');
//require('razorpay-php/Razorpay.php');
require __DIR__ . '/vendor/autoload.php';
session_start();
////////////////////////////////////////////
	$postData = $_SESSION['payDetails'];
	
	$postData1 = json_encode($postData);
	$data	=	array_shift($postData['stuFeeDetails1']);
	//print_r($data);
	//exit;
	$ADNO			=	$data['ADNO']; 
	$classId		=	$data['CLASS_ID']; 
	$FAsofBalance   =   $data['TotAmt'];
	$mobile         =   $data['contact'];
	$Year_Id        =   $data['Year_Id'];
	$name   		=   $data['name'];
	$Classs 		= 	$data['classsec'];
	$data1	=	array_shift($postData['stuFeeDetails']);
	$studentInfo = $ADNO.'-'.$Year_Id.'-'.$classId;


use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => $data['ADNO'],
    'amount'          => $data['TotAmt'] * 100, // 2000 rupees in paise
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



$sql = "INSERT INTO `razorpay` (`order_id`, `adno`, `mobile`, `amount`, `Year_Id`, `start_time`,`paydetails`) VALUES ('".$razorpayOrderId."', '".$data['ADNO']."', '".$data['contact']."', '".$data['TotAmt']."', '".$data['Year_Id']."', now(),'".$postData1."')";
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
	"YEARID"            => $Year_Id,
    "contact"           => $mobile,
    ],
    "notes"             => [
    "address"           => $ADNO.'-'.$name.'-'.$Classs.'-'.$Year_Id,
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
