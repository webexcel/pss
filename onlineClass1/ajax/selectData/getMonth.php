<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$sqlFeeHeads	=	" SELECT * FROM `feesettings` WHERE `Settings` = 'Monthly' ";
$exeFeeHeads	=	$mysqli->query($sqlFeeHeads);

$resFeeHeads	=	$exeFeeHeads->fetch_assoc();
$desc	=	$resFeeHeads['Description'];

$expdesc=	explode(',', $desc);
list($startMonth, $upto) = $expdesc;

$stm	=	date("m", strtotime($startMonth));

$arrMonth1 = array();
$arrMonth2 = array();
$months = array();
for ($i = 0; $i < 10; $i++) {  
   $month = date("M", strtotime( date( "Y-".$stm."-01" )." +$i months"));
   $months[]	=	strtoupper($month);
} 

//$arrMonth1	=	array_combine(range(1, count($months)), array_values($months));


$json_response = json_encode($months);

// # Return the response
echo $json_response;

exit;



?>