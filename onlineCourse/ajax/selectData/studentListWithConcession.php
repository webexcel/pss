<?php
//require_once('../../login/auth.php');
require_once('../../configi.php');

session_start();
$_POST	=	json_decode(file_get_contents('php://input'), true);

$adno = $_SESSION['adno'];	
$yearId	= '6';

	
if( $adno != "" ) {
	$query	=	" SELECT `class` AS CLASS_SECTION, `name`, `adno` FROM `v_course` WHERE `Year_Id` = '".$yearId."' AND `adno` = '".$adno."' and `status` = '0' limit 1 " ;
}

$result	=	mysqli_query($dbconnect, $query);
$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$_SESSION['NAME'] = $row['name'];
		$_SESSION['CLASS_SECTION'] = $row['CLASS_SECTION'];
		$_SESSION['ADMISSION_ID'] = $row['adno'];
		$arr[]		=	$row;
	}
}

$json_response = json_encode($arr);
echo $json_response;
?>