<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$adno = $data['adno'];

$query	=	" SELECT `FINE_ID`, `ADMISSION_ID`, `AMOUNT`, `REMARKS`, `INSERT_DATE`, `YEAR_ID` FROM `fee_scheme` WHERE `ADMISSION_ID` = '".$adno."' ";

$result	=	$mysqli->query($query);

$arr	=	array();
$arrs	=	array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;

		$arrs[]	=	$row;
	}
}


$json_response = json_encode($arrs);

// # Return the response
echo $json_response;
	

	

?>