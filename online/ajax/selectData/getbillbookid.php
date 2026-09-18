
<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);


$sqlbills	=	"SELECT * FROM `tbl_bill` where status = '1'";
$exebills	=	$mysqli->query($sqlbills);
$cntbills	=	$exebills->num_rows;


$arr	=	array();
if( $cntbills > 0 ) {

	while( $row = $exebills->fetch_assoc() ) {		
		$arr[]	=	$row;
		
	}

}

$json_response = json_encode($arr);
echo $json_response;
exit;



?>