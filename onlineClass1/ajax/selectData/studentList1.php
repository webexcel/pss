<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);
if( isset($_POST['section']) ) {
	$section	=	trim($_POST['section']);
} else {
	$section	=	"";
}

if( $section == "" ) {
	$query	=	"SELECT `ADMISSION_ID`, `CLASS_ID`, `CLASSSEC`, `NAME`, `FATHER_NAME`, `DOB`, `rollNumber`, `Gender` FROM `student_info1`";	
} else {
	$query	=	"SELECT `ADMISSION_ID`, `CLASS_ID`, `CLASSSEC`, `NAME`, `FATHER_NAME`, `DOB`, `rollNumber`, `Gender` FROM `student_info1` WHERE `CLASS_ID` = '".$section."'";
}

$result	=	mysqli_query($con, $query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$row['sno']	=	$sno;
		$arr[]		=	$row;	
	}
}
# JSON-encode the response
$json_response = json_encode(array("studentList" => $arr));

// # Return the response
echo $json_response;


?>