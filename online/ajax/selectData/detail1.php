<?php
require_once('../../login/auth.php');
require_once('../../login/config.php');
error_reporting(0);
	
$data = json_decode(file_get_contents('php://input'), true);


$from_date = date("Y-m-d", strtotime($data['from_date']));
$to_date = date("Y-m-d", strtotime($data['to_date']));

$arr	=	array();
foreach ($data["roles"] as $key => $value ) {
	array_push($arr, $value);
}

$arr	=	implode(', ', $arr);

//$query	=	"SELECT student_info1.ADMISSION_ID, CONCAT(tbl_class.Standard, ' - ', tbl_class.Section) as classec, $arr FROM student_info1 LEFT JOIN tbl_class ON student_info1.CLASS_ID = tbl_class.CLASS_ID LEFT JOIN stu_parents ON stu_parents.ADMISSION_ID = student_info1.ADMISSION_ID";
$query	=	"SELECT student_info1.ADMISSION_ID, CONCAT(tbl_class.Standard, ' - ', tbl_class.Section) as classec, $arr FROM student_info1 LEFT JOIN tbl_class ON student_info1.CLASS_ID = tbl_class.CLASS_ID LEFT JOIN stu_parents ON stu_parents.ADMISSION_ID = student_info1.ADMISSION_ID LEFT JOIN stu_address ON stu_address.ADMISSION_ID = student_info1.ADMISSION_ID WHERE student_info1.DOB BETWEEN '$from_date' AND '$to_date' ";


//echo "SQL : " . $query . "\n";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result)) {
	$classsec[] = $row;
}

echo json_encode($classsec);
?>
	