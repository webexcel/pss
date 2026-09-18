<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
$_POST	=	json_decode(file_get_contents('php://input'), true);
/*if( isset($_POST['select']) ) {
	$section	=	trim($_POST['select']);
} else {
	$section	=	"";
}
$section	=	$_POST['select'];

	echo $query	=	" SELECT * from student_class_map where `section` = '".$section."'";*/
	$query	=	" SELECT * from student_class_map";
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
	