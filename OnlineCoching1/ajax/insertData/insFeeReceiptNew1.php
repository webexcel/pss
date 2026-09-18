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
$sqlInsFee	=	"select * from razorpay_coach where `order_id` = '".$_POST['razorpay_order_id']."'";
$exeInsFee	=	$mysqli->query($sqlInsFee);
$postData = '';

$amountPaid = 0;   // amount charged for this order (server-computed in pay.php)
$rzYear     = '6';
if ($exeInsFee->num_rows > 0) {
    $row        = $exeInsFee->fetch_assoc();
    $postData   = $row['paydetails'];
    $amountPaid = (int)$row['amount'];
    $rzYear     = !empty($row['Year_Id']) ? $row['Year_Id'] : '6';

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
	$game			=	$data[0]['game'];
	$payment_id		=	$_POST['razorpay_payment_id'];////////

	$adnoEsc	=	$mysqli->real_escape_string($ADNO);
	$gameEsc	=	$mysqli->real_escape_string($game);
	$payEsc		=	$mysqli->real_escape_string($payment_id);

	// Dedup: has this exact Razorpay payment already been recorded?
	$dup	=	$mysqli->query("SELECT `pay_id` FROM `v_coachlist` WHERE `pay_id` = '".$payEsc."' LIMIT 1");

	if ($dup && $dup->num_rows > 0) {
		echo "Payment already exist";
	} else {
		// Has this student paid before? (any earlier row carrying a pay_id)
		$paidChk		=	$mysqli->query("SELECT COUNT(*) AS c FROM `v_coachlist` WHERE `adno` = '".$adnoEsc."' AND `pay_id` IS NOT NULL");
		$alreadyPaid	=	($paidChk && (int)($paidChk->fetch_assoc()['c']) > 0);

		if (!$alreadyPaid) {
			// NEW student -> fill in their existing (unpaid) roster row with the Rs.5000 payment
			$mysqli->query("UPDATE `v_coachlist`
				SET `description` = '".$gameEsc."', `pay_id` = '".$payEsc."', `amount` = '".$amountPaid."', `insDate` = now()
				WHERE `adno` = '".$adnoEsc."' AND `pay_id` IS NULL
				ORDER BY `id` LIMIT 1");
		} else {
			// ALREADY PAID (old Rs.3500) -> INSERT a NEW row for the Rs.1500 top-up
			$info	=	$mysqli->query("SELECT `class`,`name`,`contact` FROM `v_coachlist` WHERE `adno` = '".$adnoEsc."' ORDER BY `id` LIMIT 1");
			$st		=	($info && $info->num_rows > 0) ? $info->fetch_assoc() : array('class'=>'','name'=>'','contact'=>'');
			$clsEsc	=	$mysqli->real_escape_string($st['class']);
			$nmEsc	=	$mysqli->real_escape_string($st['name']);
			$ctEsc	=	$mysqli->real_escape_string($st['contact']);

			$mysqli->query("INSERT INTO `v_coachlist`
				(`adno`,`class`,`name`,`contact`,`description`,`pay_id`,`amount`,`insDate`,`Year_Id`,`status`)
				VALUES
				('".$adnoEsc."','".$clsEsc."','".$nmEsc."','".$ctEsc."','".$gameEsc."','".$payEsc."','".$amountPaid."',now(),'".$rzYear."','0')");
		}
	}

}
?>