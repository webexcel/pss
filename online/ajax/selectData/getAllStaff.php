<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data   =   json_decode(file_get_contents('php://input'), true);


$yearId		=	$_SESSION['YEAR_ID'];

	$query	=	" SELECT * FROM `p_staff_info` WHERE Year_Id = '".$yearId."'";	
	$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$arr[]		=	$row;
	}
}


$json_response = json_encode($arr);

echo $json_response;

exit;





?>
	