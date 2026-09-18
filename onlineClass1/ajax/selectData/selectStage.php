<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);
if( isset($_POST['section']) ) {
	$section	=	trim($_POST['section']);
} else {
	$section	=	"";
}

if( $section == "" ) {
	$query	=	" SELECT `CLASS_ID`, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` ORDER BY `CLASS_ID` ASC ";	
} else {
	$query	=	" SELECT `CLASS_ID`, Standard AS STD, Section AS SEC, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` WHERE `CLASS_ID` = '".$section."' ";
}
//echo $query;
$result	=	mysqli_query($con, $query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$row['sno']	=	$sno;
		$std	=	$row['STD'];
		$sec	=	($row['SEC']) ? '-'.$row['SEC'] : '';
		$std_sec=	$std . $sec;
		$row['STD_SEC'] =	$std_sec;
		$cquery		=	" SELECT sum(CONCESSION_AMOUNT) AS CONCESSION_AMOUNT FROM fee_concession where ADMISSION_ID = '".$row['ADMISSION_ID']."' ";
		$cresult	=	mysqli_query($con, $cquery);
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