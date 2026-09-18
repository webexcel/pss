<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);


$sqlFeeHeads	=	"SELECT application_class.class_id,application_class.amount,tbl_class.Standard FROM application_class join tbl_class on (application_class.class_id = tbl_class.CLASS_ID) ";

//echo "SQL : " . $sqlFeeHeads . "<br />";

$exeFeeHeads	=	$mysqli->query($sqlFeeHeads);
$cntFeeHeads	=	$exeFeeHeads->num_rows;
if( $cntFeeHeads > 0 ) {

	while( $row = $exeFeeHeads->fetch_assoc() ) {		
		
		$arr[]	=	$row;
		
	}

}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>