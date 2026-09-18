<html>
<head>
<link rel="stylesheet" href="../dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<style>
table,th{
	background:#307ecc;
	color:#fff;
}
table,td{

	color:#000;
	font-size:16px;
	font-weight:bold;
}
button{
	background:#307ecc;
	color:#fff;
}
	
</style>


<body>

<?php
require('config.php');
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$success = true;
$error = "Payment Failed";
	$servername = "localhost";
	$username = "main";
	$password = "P@mani4u";
	$dbname = "pssenior";
$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		echo "Please Contact Admin <br>";
	  die("Connection failed: " . $conn->connect_error);
	}
	
if (empty($_POST['razorpay_payment_id']) === false)
{
	
    $api = new Api($keyId, $keySecret);
    try
    {

		$qry = "Select order_id  from `razorpay_coach` where order_id = '".$_POST['razorpay_order_id']."' ";
		$result = $conn->query($qry);
		$row = mysqli_fetch_assoc($result);
		$order_id = $row['order_id'];
		if ($result){
			
		$attributes = array(
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );	
		}
        $api->utility->verifyPaymentSignature($attributes);
		//////// Dual Verification Method///////////////////////
		$fetchpayDetails = $api->payment->fetch($_POST['razorpay_payment_id']);
		//print_r($fetchpayDetails);
		
		$razorpay_payment_id = $fetchpayDetails['id'];
		$razorpayOrder_id = $fetchpayDetails['order_id'];
		$razorpayamount = $fetchpayDetails['amount']/100;
		$razorpaystatus = $fetchpayDetails['status'];
		
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}else{
	header("Location: failure.php"); ;
	
}

	if($razorpaystatus == 'captured')
	{
		if ($success === true)
		{
			$sql = "update  `razorpay_coach` set end_time = now() , payment_id ='".$razorpay_payment_id."' , signature = '".$_POST['razorpay_signature']."', status='COMPLETED' where order_id = '".$razorpayOrder_id."' ";

			if ($conn->query($sql) === TRUE) {
			  $html = "<div class='container'>
				<div id='login-box' class='col-md-12'>
					<div class='card-header mx-auto center'>
						<img src='images/logo.png' width='75px' height='75px' alt='Logo' class='center'/>
						<h3>P.S.Senior Secondary School</h3>
					</div>
					<table class='table table-bordered'>
						<thead>
							<th>Payment Details</th>
							<th> </th>
							<th>Payment Status</th>
						</thead>
						<tbody>
							<tr class='table-success'>
							<td>Payment Mode</td>
							<td> : </td>
							<td>Your payment was successful</td>
							</tr>
							<tr class='table-primary'>
							<td>Payment Id</td>
							<td> : </td>
							<td>{$razorpay_payment_id}</td>
							</tr>
							<tr class='table-danger'>
							<td>Order ID</td>
							<td> : </td>
							<td>{$razorpayOrder_id}</td>
							</tr>
							<tr class='table-primary'>
							<td>Amount</td>
							<td> : </td>
							<td> {$razorpayamount}</td>
							</tr>
							<tr class='table-danger'>
							<td></td>
							<td> : </td>							
							<td><a href='fee-details-new1.php' class='btn btn success'>Take Print </a></td>
							</tr>";
				} else {
				  $html = "<td>Your payment was successful, yet somthing went wrong ".$conn->error ."</p>
						 <td>Payment IDq: {$_POST['razorpay_payment_id']}</td>";
				 
				}
			require_once('ajax/insertData/insFeeReceiptNew1.php');	
		}
		else{
			$sql = "update  `razorpay_coach` set end_time = now() , payment_id ='".$_POST['razorpay_payment_id']."' , signature = '".$_POST['razorpay_signature']."', status='FAILED',remarks='".$error."' where order_id = '".$_POST['razorpay_order_id']."' ";

			if ($conn->query($sql) === TRUE) {
			  $html = "<p>Your payment failed</p>
					 <p>{$error}</p>";
			} else {
			  $html = "<p>Your payment failed</p>
					 <p>{$error}</p>". $conn->error;			 
			}
		}	
	}else{			
		require('failure.php');
	
	}	

echo $html;
