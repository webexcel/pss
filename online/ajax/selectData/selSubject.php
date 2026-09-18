<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);

//$class_id	=	trim($_POST['class_id']);
/*
$query	=	"SELECT `subject_id` FROM `tbl_class` WHERE `CLASS_ID` = '".$class_id."'";
$result	=	mysqli_query($con, $query);
if($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$sub_id	=	str_replace('|', ',', $row['subject_id']);
}
*/
//if($sub_id != '' ) {
	$query	=	"SELECT `sub_id`, `subject_name` FROM `tbl_subject` ORDER BY subject_name ASC";
	$result	=	mysqli_query($con, $query);

	$arr = array();
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$arr[] = $row;	
		}
	}
//} else {
//	$arr['status'] = 'No records';
//}

# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;


?>