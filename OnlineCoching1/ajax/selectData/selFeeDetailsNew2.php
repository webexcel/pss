<?php

require_once('../../configi.php');
session_start();


$_POST	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	'6';
$adno = mysqli_real_escape_string($dbconnect, $_POST['adno']);

/* ---- New fee concept ----
   Total Online Coaching fee is now Rs.5000.
   - New student (never paid)        -> pay Rs.5000
   - Already paid old Rs.3500 student -> pay only the balance Rs.1500
   - Fully paid (>= 5000)            -> balance 0 (nothing to pay)
   The amount actually paid is stored in v_coachlist.`amount`.            */
$FEE_TOTAL = 5000;

// Student info (one row is enough for name/class)
$query	=	" SELECT  `class` AS CLASS_SECTION, `name`, `adno`  FROM `v_coachlist` WHERE `adno` = '".$adno."' and `Year_Id` = '".$yearId."' ORDER BY `id` LIMIT 1";
$result	=	mysqli_query($dbconnect, $query);
$arr = array();

if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr['ADNO'] 		=	$row['adno'];
		$arr['NAME']		=	$row['name'];
		$arr['SECTION']		=	$row['CLASS_SECTION'];
	}
}

// Total already paid = SUM across all of this student's rows (first payment + top-ups)
$paid = 0;
$sumQ = mysqli_query($dbconnect, "SELECT COALESCE(SUM(`amount`),0) AS PAID FROM `v_coachlist` WHERE `adno` = '".$adno."' AND `Year_Id` = '".$yearId."'");
if($sumQ && ($sumRow = mysqli_fetch_assoc($sumQ))) { $paid = (int)$sumRow['PAID']; }

$balance = $FEE_TOTAL - $paid;
if($balance < 0) { $balance = 0; }

$arr['FEE_TOTAL']	=	$FEE_TOTAL;	// full coaching fee
$arr['PAID']		=	$paid;		// already paid so far
$arr['amount']		=	$balance;	// amount to pay now (5000 / 1500 / 0)

$sqlFeeHistory	=	"SELECT `description`,`pay_id`,date(`insDate`) as `insDate`, COALESCE(`amount`,0) AS `amount` FROM `v_coachlist` WHERE `adno` = '".$adno."' AND `pay_id` IS NOT NULL";
$exeFeeHistory	=	mysqli_query($dbconnect,$sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;
$t = 0;
$arrT2['TOT_HISTORY'] = array();
if( $cntFeeHistory > 0 ) {
	while( $row1 = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHis = array();
		$arrFeeHis['sno']		= 	$t++;
		$arrFeeHis['date']		=	$row1['insDate'];
		$arrFeeHis['pay_id']	=	$row1['pay_id'];
		$arrFeeHis['game']		=	$row1['description'];
		$arrFeeHis['amount']	=	(int)$row1['amount'];
		$arrT2['TOT_HISTORY'][] 	= 	$arrFeeHis;
	}
}

$arr	=	array_merge($arr, $arrT2);
$json_response = json_encode($arr);
echo $json_response;
exit;
	

?>