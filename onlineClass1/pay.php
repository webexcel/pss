<?php
require('config.php');
require('razorpay-php/Razorpay.php');
session_start();
////////////////////////////////////////////
	$postData = $_SESSION['payDetails'];
	
	$postData1 = json_encode($postData);
	$data	=	array_shift($postData['stuFeeDetails1']);
	//print_r($data);
	//exit;
	$ADNO			=	$data['ADNO']; 
	$classsec		=	$data['classsec']; 
	$gametype		=	$data['gametype']; 
	$ASamount	    =   3500;// change here
	$mobile         =   $data['contact'];
	$Year_Id        =   '5';
	$name   		=   $data['name'];
	$studentInfo = $ADNO.'-'.$Year_Id.'-'.$classsec;


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

$servername = "localhost";
$username = "main";
$password = "P@mani4u";
$dbname = "pssenior";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	echo "Please Contact Admin <br>";
  die("Connection failed: " . $conn->connect_error);
  
}

$sql = "INSERT INTO `razorpay_coach` (`order_id`, `adno`, `mobile`, `amount`, `Year_Id`, `start_time`,`paydetails`) VALUES 
('".$razorpayOrderId."', '".$data['ADNO']."', '".$data['contact']."', '".$ASamount."', '".$Year_Id ."', now(),'".$postData1."')";
if ($conn->query($sql) === TRUE) {
  $last_id = mysqli_insert_id($conn);
			$_SESSION['razorid'] = $last_id;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  die('Something went wrong!');
}
$conn->close();
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
