<?php
//require_once('../../login/auth.php');
require_once('../../configi.php');

session_start();
$_POST	=	json_decode(file_get_contents('php://input'), true);

$adno = $_SESSION['adno'];	
$yearId	= $_SESSION['yearid'];

	
if( $adno != "" ) {
	$query	=	" SELECT `CLASS_ID` as CLASS_ID, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` WHERE `Year_Id` = '".$yearId."' AND `ADMISSION_ID` = '".$adno."'  ORDER BY `CLASS_ID` ASC ";	
}

$result	=	mysqli_query($dbconnect, $query);
$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$row['sno']	=	$sno;
		$_SESSION['NAME'] = $row['NAME'];
		$_SESSION['FATHER_NAME'] = $row['FATHER_NAME'];
		$_SESSION['ADMISSION_ID'] = $row['ADMISSION_ID'];
		$cquery		=	" SELECT sum(CONCESSION_AMOUNT) AS CONCESSION_AMOUNT FROM fee_concession where ADMISSION_ID = '".$row['ADMISSION_ID']."' AND yearId = '".$yearId."'";
		$cresult	=	mysqli_query($dbconnect, $cquery);
		$crow 		=	$cresult->fetch_assoc();		
		$row['CONCESSION_AMOUNT'] = $crow['CONCESSION_AMOUNT'];
		$arr[]		=	$row;
	}
}
# JSON-encode the response
$json_response = json_encode($arr);
// # Return the response
echo $json_response;
?>