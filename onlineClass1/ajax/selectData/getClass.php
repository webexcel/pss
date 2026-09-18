<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);


$sqlFeeHeads	=	"SELECT `CLASS_ID`, `Standard` AS STANDARD, `Section` AS SECTION FROM `tbl_class` WHERE `Status` = '1' order by feeGrpId";

//echo "SQL : " . $sqlFeeHeads . "<br />";

$exeFeeHeads	=	$mysqli->query($sqlFeeHeads);
$cntFeeHeads	=	$exeFeeHeads->num_rows;


//$arr['CLASS']	=	array();
if( $cntFeeHeads > 0 ) {

	while( $row = $exeFeeHeads->fetch_assoc() ) {		
		//$arr['CLASS'][]	=	$row;
		
		$sec	=	($row['SECTION']) ? '-'.$row['SECTION'] : $row['SECTION'];
		
		$row['CLASS_AND_SECTION'] = $row['STANDARD'] . $sec;
		$arr[]	=	$row;
		
	}

}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>