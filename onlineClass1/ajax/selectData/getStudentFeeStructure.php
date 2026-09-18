<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$yearId		=	$_SESSION['YEAR_ID'];

//$sqlSelStrength	= "call student_count('".$yearId."')";
//echo $sqlSelStrength;
$sqlSelStrength	=	" CALL student_fee_structure('".$yearId."') " ;
$exeSelStrength	=	$mysqli->query($sqlSelStrength);
$numSelStrength	=	$exeSelStrength->num_rows;

if( $numSelStrength > 0 ) {
	$arr	=	array();
	while( $row = $exeSelStrength->fetch_assoc() ) {
		$arr[]	=	$row;
	}
	
	$sumArray = array();
/*
	foreach ($arr as $k=>$subArray) {
		foreach ($subArray as $id => $value) {
			if($id == 'Section') {
				$sumArray[$id] = 'TOTAL';
			} else {
				$sumArray[$id] += $value;
			}
		}
	}*/
	$aarr[] = $sumArray;
	
	$narr	=	array_merge($arr, $aarr);
	
} else {
	$narr	=	array('error' => TRUE, 'message' => 'No results found. ');	
}


# JSON-encode the response
$json_response = json_encode($narr);

# Return the response
echo $json_response;


exit;


?>
	