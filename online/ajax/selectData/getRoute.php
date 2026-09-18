<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
$data	=	json_decode(file_get_contents('php://input'), true);

$sqlRoute	=	"SELECT DISTINCT `route` FROM `van_stage` ";
$exeRoute	=	$mysqli->query($sqlRoute);
$cntRoute	=	$exeRoute->num_rows;

if( $cntRoute > 0 ) {

	while( $row = $exeRoute->fetch_assoc() ) {		
		$sec	= $row['route'];
		$arr[]	= $sec;		
	}
}

$json_response = json_encode($arr);
echo $json_response;
exit;
?>