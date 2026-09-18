<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();


$query	=	" SELECT T1.`ADMISSION_ID`, T1.`CLASSSEC`, T1.`NAME`, T1.`FATHER_NAME`, T2.`FEE_TYPE`, T2.AMOUNT, T2.REMARKS, T2.INSERT_DATE  FROM `v_studentlist` T1, `fee_fine` T2   WHERE T1.`ADMISSION_ID` = T2.`ADMISSION_ID` AND T1.YEAR_ID = '".$_SESSION['YEAR_ID']."'";
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