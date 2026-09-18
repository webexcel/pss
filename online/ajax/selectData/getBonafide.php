<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');


$sqlSelBonafide	=	" SELECT `bonafide_id`, `bonafide_date`, `name`, `class`, `dob`, `description` FROM `bonafide` WHERE 1 ORDER BY `bonafide_id` DESC " ;
$exeSelBonafide	=	$mysqli->query($sqlSelBonafide) or die($mysqli->error);
$numSelBonafide	=	$exeSelBonafide->num_rows;

if( $numSelBonafide > 0 ) {
	$arr	=	array();
	while( $row = $exeSelBonafide->fetch_assoc() ) {
		$arr[]	=	$row;
	}
} else {
	$arr	=	array('error' => TRUE, 'message' => 'No results found. ');	
}


# JSON-encode the response
$json_response = json_encode($arr);

# Return the response
echo $json_response;


exit;


?>
	