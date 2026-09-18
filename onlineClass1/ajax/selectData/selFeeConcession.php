<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);

$adno = $_POST['adno'];

$query	=	" SELECT `FEE_CON_ID`, `ADMISSION_ID`, `CONCESSION_AMOUNT`, `CONCESSION_APPROVED_BY`, `CONCESSION_REMARKS`, `CONCESSION_APPROVED_DATE`, `CONCESSION_STATUS` FROM `fee_concession` WHERE `ADMISSION_ID` = '".$adno."' AND yearId = '".$_SESSION['YEAR_ID']."' ";
//echo "SQL : " . $query . "<br />";
$result	=	$mysqli->query($query);

$arr	=	array();
$arrs	=	array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		
		$arr['FEE_CON_ID']				=	$row['FEE_CON_ID'];
		$arr['ADMISSION_ID']			=	$row['ADMISSION_ID'];
		$arr['CONCESSION_AMOUNT']		=	$row['CONCESSION_AMOUNT'];
		$arr['CONCESSION_APPROVED_BY']	=	$row['CONCESSION_APPROVED_BY'];
		$arr['CONCESSION_REMARKS']		=	$row['CONCESSION_REMARKS'];
		$arr['CONCESSION_APPROVED_DATE']		=	$row['CONCESSION_APPROVED_DATE'];
		$arrs[]	=	$arr;
	}
}


$json_response = json_encode($arrs);

// # Return the response
echo $json_response;
	

	

?>