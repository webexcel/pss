<?php
////////////////////////////////////////////
	$postData = $_SESSION['payDetails'];
	$data	=	array_shift($postData['stuFeeDetails1']);
	$ADNO			=	$data['ADNO']; 
	$classId		=	$data['CLASS_ID'];
	$FAsofBalance   =   $data['TotAmt'];
	$classsec   	=   $data['classsec'];
	$name   		=   $data['name'];
	$data1	=	array_shift($postData['stuFeeDetails']);
	//$FAsofBalance		=	$data1['FAsofBalance'];	
	/////////////////////////////////////////////////////
	?>
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
}
button{
	background:#307ecc;
	color:#fff;
}
	
</style>


<body>
<!-- HEADER -->
	<?php include('checkout/navbar.php'); ?>  <!-- /.navbar-container --> 
	<!-- ./ HEADER -->	
<div class="container">
	<div id="login-box" class="col-md-12">
		<div class="card-header mx-auto center">
			<img src="images/logo.png" width="75px" height="75px" alt="Logo" class="center"/>
			<h3>P.S.Senior Secondary School</h3>
		</div>
		<form method="POST" action="https://api.razorpay.com/v1/checkout/embedded">
		
		<table class="table table-bordered">
			<thead>
				<th>Class</th>
				<th>Admission No</th>
				<th>Name</th>								
				<th>Payable Amount</th>
			</thead>
			<tbody>
				<tr>
				<td><?php echo $data['classsec']?></td>
					<td><?php echo $data['ADNO'];?></td>
					<td><?php echo $data['name']?></td>
					<td>Rs. <?php echo $data['TotAmt']?></td>
					<input type="hidden">
				</tr>
				
				<tr>
					<td colspan="3" style="text-align:right;">Enter Email</td>
					<td><input class="form-control" name="prefill[email]" value="" required></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><table class="table table-bordered">
					<thead>
						<th colspan="4">Bank Gateway Charges will be added to Fee Amount for using software. School does not charge apart from school fees </th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>UPI Payment</td>
							<td>Rs.00</td>
							<td> - </td>
						</tr>
						<tr>
							<td>2</td>
							<td>Debit Card</td>
							<td>Rs.00</td>
							<td> - </td>
						</tr>
						<tr>
							<td>3</td>
							<td>Net Banking</td>
							<td>Rs.30 lessthen</td>
							<td>Tax Extra 18%</td>
						</tr>
						<tr>
							<td>4</td>
							<td>Credit Card</td>
							<td>1% of the Fee Amount</td>
							<td>Tax Extra 18%</td>
						</tr>
						<tr>
							<td>5</td>
							<td>International Credit Card</td>
							<td>2.5% of the Fee Amount</td>
							<td>Tax Extra 18%</td>
						</tr>
						
					</tbody>
					</table>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3">
						<input type="hidden" name="key_id" value="rzp_live_N1R53Ubks63NBg">
						<input type="hidden" name="order_id" value="<?php echo $razorpayOrderId; ?>">
						<input type="hidden" name="amount" value="<?php echo $amount; ?>">
						<input type="hidden" name="name" value="HDFC VAS">
						<input type="hidden" name="description" value="P.S.Senior Secondary School">
						<input type="hidden" name="prefill[contact]" value="<?php echo $mobile; ?>">
						<input type="hidden" name="notes[transaction_id]" value="<?php echo $studentInfo; ?>">
						<input type="hidden" name="callback_url" value="https://pssenior.edu.in/online/verify.php">
					</td>
					<td><button type="submit" id="rzp-button1">Process to Pay</button></td>
				</tr>
			</tbody>
		</table>
		<!--<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
		<form name='razorpayform' action="verify.php" method="POST">
			<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
			<input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
		</form>-->
		
		
		
		</form>

	</div>
</div>
</body>
</html>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>