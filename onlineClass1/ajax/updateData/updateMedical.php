<?php
error_reporting(0);
require_once('../../login/auth.php');
require_once('../../login/config.php');


$_POST = json_decode(file_get_contents('php://input'), true);

foreach ($_POST as $key => $value ) {
	$data = explode('|', $value);
	$columnName = $key;
	$valuq = $value;
}

$ADMISSION_ID = $_POST['ADMISSION_ID'];
$sqlUpStuMed = "UPDATE `stu_medical` SET $columnName ='$valuq' WHERE `ADMISSION_ID`='$ADMISSION_ID'";	
$exeUpStuMed = mysql_query($sqlUpStuMed);
while($row = mysql_fetch_array($exeUpStuMed)){
	$data = $row;
}

print json_encode($data);
	
?>