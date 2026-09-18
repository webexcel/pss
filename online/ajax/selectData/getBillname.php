
<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);


$sqlFeeHeads	=	"SELECT * FROM `tbl_serial_no` where status = '1'";
$exeFeeHeads	=	$mysqli->query($sqlFeeHeads);
$cntFeeHeads	=	$exeFeeHeads->num_rows;


$arr	=	array();
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