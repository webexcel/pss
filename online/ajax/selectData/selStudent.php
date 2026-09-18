<?php
require_once('../../login/auth.php');
require_once('../../login/config.php');

error_reporting(0);

$data	=	array();

$_POST	=	json_decode(file_get_contents('php://input'), true);

$adno	=	$_POST['adno'];
	
if($adno !="" ) {
	//$query = "SELECT *, CONCAT(Standard,' - ',Section) as classec, grp as grpp, IILanguage as langg FROM student_info1 LEFT JOIN tbl_class ON student_info1.CLASS_ID = tbl_class.CLASS_ID LEFT JOIN stu_address ON student_info1.ADMISSION_ID = stu_address.ADMISSION_ID LEFT JOIN  stu_parents ON student_info1.ADMISSION_ID = stu_parents.ADMISSION_ID WHERE student_info1.ADMISSION_ID='$adno'";	
	$query = "SELECT *, student_info1.ADMISSION_ID, CONCAT(Standard,' - ',Section) AS classec, student_info1.Group AS grpp, IILanguage AS langg FROM student_info1 LEFT JOIN tbl_class ON student_info1.CLASS_ID = tbl_class.CLASS_ID LEFT JOIN stu_address ON student_info1.ADMISSION_ID = stu_address.ADMISSION_ID LEFT JOIN stu_parents ON student_info1.ADMISSION_ID = stu_parents.ADMISSION_ID LEFT JOIN stu_medical ON student_info1.ADMISSION_ID = stu_medical.ADMISSION_ID LEFT JOIN stu_others ON student_info1.ADMISSION_ID = stu_others.ADMISSION_ID WHERE student_info1.ADMISSION_ID='$adno'";	

}

$exequery = mysql_query($query);

while($row = mysql_fetch_assoc($exequery)){
	$data = $row;
}

echo json_encode($data);
exit
?>