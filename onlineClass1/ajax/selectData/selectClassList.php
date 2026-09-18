<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');
/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'palert');
define('DB_USERNAME', 'root');

$db_pass	=	($_SERVER['HTTP_HOST']=='localhost') ? '' : 'webexcel@123';
define('DB_PASSWORD', $db_pass);


$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

*/

/*
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$section = $request->section;
*/

$_POST	=	json_decode(file_get_contents('php://input'), true);

$section	=	trim($_POST['section']);
$modeofExam	=	trim($_POST['modeOfExam']);

//$sub	=	strtolower(trim($_POST['subject']));
//$subject=	str_replace(' ' ,'' ,$sub);

$sub	=	$_POST['subject'];
$subject_id		=	$sub['sub_id'];
$subject_name	=	$sub['subject_name'];

//$query	=	"SELECT T1.ADMISSION_ID, T1.NAME, T2.markID, T2.$subject  FROM `student_info1` T1 LEFT JOIN `tbl_marks` T2 ON T1.ADMISSION_ID = T2.ADMISSION_ID AND T2.modeOfExam = '".$modeofExam."' WHERE T1.`CLASS_ID` = '".$section."' ORDER BY T1.NAME ASC";
$query	=	"SELECT T1.ADMISSION_ID, T1.NAME, T2.markID, T2.subject_id, T2.mark  FROM `student_info1` T1 LEFT JOIN `tbl_marks1` T2 ON T1.ADMISSION_ID = T2.ADMISSION_ID AND T2.subject_id = '".$subject_id."' AND T2.modeOfExam = '".$modeofExam."' WHERE T1.`CLASS_ID` = '".$section."' ORDER BY T1.NAME ASC";
$result	=	mysqli_query($con, $query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$row['SNO'] = $sno;
		$row['modeOfExam'] = $modeofExam;
		$row['subject_id']	=	$subject_id;
		$row['subject_name']=	$subject_name;
		$row['mark']		=	$row['mark'];
		$arr[] = $row;	
	}
}


# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;


?>