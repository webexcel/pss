<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');
require('pivot.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);

$section	=	trim($_POST['section']);
$modeofExam	=	trim($_POST['modeOfExam']);

//$query	=	"SELECT T1.ADMISSION_ID, T1.NAME, T2.markID, T2.tamil, T2.english, T2.maths, T2.science, T2.socialScience  FROM `student_info1` T1 LEFT JOIN `tbl_marks` T2 ON T1.ADMISSION_ID = T2.ADMISSION_ID AND T2.modeOfExam = '".$modeofExam."' WHERE T1.`CLASS_ID` = '".$section."' ORDER BY T1.NAME ASC";
$query	=	"SELECT T1.ADMISSION_ID, T1.NAME, T2.markID, T2.subject_id, T2.subject_name, T2.mark  FROM `student_info1` T1 LEFT JOIN `tbl_marks1` T2 ON T1.ADMISSION_ID = T2.ADMISSION_ID AND T2.modeOfExam = '".$modeofExam."' WHERE T1.`CLASS_ID` = '".$section."' ORDER BY T1.NAME ASC";
$result	=	mysqli_query($con, $query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$row['SNO'] = $sno;
		$row['modeOfExam'] = $modeofExam;
		$arr[] = $row;	
	}
}

$data = Pivot::factory($arr)
    ->pivotOn(array('ADMISSION_ID', 'NAME'))
    ->addColumn(array('subject_name'), array('mark'))
    ->fetch();

echo "<pre>";
print_r($data);
# JSON-encode the response
$json_response = json_encode($data);

// # Return the response
echo $json_response;


exit;
$student	=	array();
$students	=	array();
foreach( $arr as $key => $val ) {
	//print_r($key);
	//echo "------";
	//print_r($val);
	
	$student['ADMISSION_ID'] = $val['ADMISSION_ID'];
	$student['NAME'] = $val['NAME'];
	$student['SUBJECT_ID'] = $val['subject_id'];
	//$student['SUBJECT_NAME'] = $val['subject_name'];
	//$student[$val['subject_name']] = $val['mark'];
	$student[$val['subject_name']] = $val['mark'];
	//$students[]	=	$student;
	//print_r($student);
	
	
}

echo "<pre>";
print_r($students);
exit;

# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;


?>