<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$yearId	    =	$_SESSION['YEAR_ID'];

$sqlSelvoucher	=	" SELECT `id`, `date`, `name`,`description`,`approved`,`amount` FROM `cash_voucher` WHERE `Year_Id` = '".$yearId."' ORDER BY `id` DESC " ;
$exeSelvoucher	=	$mysqli->query($sqlSelvoucher) or die($mysqli->error);
$numSelvoucher	=	$exeSelvoucher->num_rows;

if( $numSelvoucher > 0 ) {
	$arr	=	array();
	while( $row = $exeSelvoucher->fetch_assoc() ) {
		$arr[]	=	$row;
	}
} else {
	$arr	=	array('error' => TRUE, 'message' => 'No results found. ');	
}


# JSON-encode the response
$json_response = json_encode($arr);

# Return the response
echo $json_response;


exit;


?>
	