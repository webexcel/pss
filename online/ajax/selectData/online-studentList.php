<?php

$dbconnect = new  mysqli('localhost','root','webexcel@123','demosch'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

session_start();
$_POST	=	json_decode(file_get_contents('php://input'), true);

$yearId	=	'3';
	
if( $section == "" ) {
	$query	=	" SELECT `CLASS_ID` as CLASS_ID, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` WHERE `Year_Id` = '".$yearId."'  ORDER BY `CLASS_ID` ASC ";	
	//$query	=	" SELECT `CLASS_ID` as CLASS_ID, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist`  ORDER BY `CLASS_ID` ASC ";	
} 
else {
		$query	=	" SELECT `CLASS_ID` as CLASS_ID, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` WHERE `Year_Id` = '".$yearId."' AND `CLASS_ID` = '".$section."'  ORDER BY `CLASS_ID` ASC ";	
}
//echo $query;
$result	=	mysqli_query($con, $query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$row['sno']	=	$sno;
		/*$std	=	$row['STD'];
		$sec	=	($row['SEC']) ? '-'.$row['SEC'] : '';
		$std_sec=	$std . $sec;
		$row['STD_SEC'] =	$std_sec;*/
		$cquery		=	" SELECT sum(CONCESSION_AMOUNT) AS CONCESSION_AMOUNT FROM fee_concession where ADMISSION_ID = '".$row['ADMISSION_ID']."' AND yearId = '".$yearId."'";
		$cresult	=	mysqli_query($con, $cquery);
		$crow 		=	$cresult->fetch_assoc();		
		$row['CONCESSION_AMOUNT'] = $crow['CONCESSION_AMOUNT'];
		$arr[]		=	$row;
	}
}
/*
$queryss	=	"SELECT `Config_Value` FROM `configuration` WHERE `Config_Type` = 'CONS'";
$resultss	=	mysqli_query($con, $queryss);
$arrs = array();
while($row = $resultss->fetch_assoc()) {		
	$rowss['Config_Value'] = $row['Config_Value'];
	$arrs[]		=	$rowss;	
}

$arre = array_merge($arr,array('res'=> $arrs));*/

# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;


?>