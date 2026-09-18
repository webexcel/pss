<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data   =   json_decode(file_get_contents('php://input'), true);

$str_arr =  $data['adno'][0]; 
$yearId	=	$_SESSION['YEAR_ID'];
		
	$query	= "SELECT * FROM v_studentlist WHERE Year_Id = '".$yearId."' AND ADMISSION_ID IN ('" . implode("','", $str_arr) . "')";
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
	