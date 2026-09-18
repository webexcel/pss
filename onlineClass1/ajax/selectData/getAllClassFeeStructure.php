<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

session_start();
$data		=	json_decode(file_get_contents('php://input'), true);

$yearId	=	$_SESSION['YEAR_ID'];
//$feeGroupId	=	$data['feeGroup'];

//$sqlAllFeeStructure	=	"SELECT CONCAT(T2.Standard,'-',T2.Section) AS CLASS_SECTION, T1 .* FROM v_fees T1, tbl_class T2 WHERE T1.CLASS_ID=T2.CLASS_ID AND T2.Status = 1 ORDER BY CLASS_ID ASC ";
$sqlAllFeeStructure	=	"SELECT CONCAT(T2.Standard,'-',T2.Section) AS CLASS_SECTION, T1 .* FROM v_fees T1, tbl_class T2 WHERE T1.CLASS_ID=T2.CLASS_ID AND T2.Status = 1 AND T1.Year_Id = '".$yearId."' ORDER BY CLASS_ID ASC ";

//echo "SQL : " . $sqlFeeGroup . "<br />";

$exeAllFeeStructure	=	$mysqli->query($sqlAllFeeStructure);
$cntAllFeeStructure	=	$exeAllFeeStructure->num_rows;

$arr  =	array();
if( $cntAllFeeStructure > 0 ) {

	while( $row = $exeAllFeeStructure->fetch_assoc() ) {	
		$temp = array();	
		$temp['CLASS_SECTION'] = $row['CLASS_SECTION'];
		$temp['feehead'] 	= $row['feehead'];
		$temp['feetype'] 	= $row['feetype'];
		$temp['interval'] 	= $row['interval'];
		$temp['instalment'] = $row['instalment'];
		$temp['feeamount'] 	= $row['feeamount'];
		$arr[]	=	$temp;
	}

}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>