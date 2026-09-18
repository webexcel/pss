<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data   =   json_decode(file_get_contents('php://input'), true);


if( isset($data['section']) ) {
	$section	=	trim($data['section']);
} else {
	$section	=	"";
}
$yearId		=	$_SESSION['YEAR_ID'];

if( $section == "" ) {
	$query	=	" SELECT T1.Standard,T1.Section,T1.CLASSSEC,T1.NAME,T1.ADMISSION_ID,T2.IILanguage from v_studentlist T1 join student_info1 T2 on T2.ADMISSION_ID = T1.ADMISSION_ID where T1.Year_Id = '".$yearId."'; ";		
} else {
	$query	=	" SELECT T1.Standard,T1.Section,T1.CLASSSEC,T1.NAME,T1.ADMISSION_ID,T2.IILanguage from v_studentlist T1 join student_info1 T2 on T1.ADMISSION_ID = T2.ADMISSION_ID  where T1.Year_Id = '".$yearId."' AND T1.CLASS_ID = '".$section."'; ";
}
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
	