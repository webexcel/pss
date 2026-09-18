<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
$_POST	=	json_decode(file_get_contents('php://input'), true);
$query	=	" SELECT * FROM appication";
$result	=	$mysqli->query($query);
$arr = array();
if($result->num_rows > 0) {	
	while($row = $result->fetch_assoc()) {	
		$row['U_PDF']	=	$_SESSION['SESS_MEMBER_DBNAME'];
		$arr[]		=	$row;
		
	}
}
$json_response = json_encode($arr);
echo $json_response;
exit;
?>	