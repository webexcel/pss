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
$sqlUpStuParents = "UPDATE `stu_others` SET $columnName ='$valuq' WHERE `ADMISSION_ID`='$ADMISSION_ID'";	
$exeUpStuParents = mysql_query($sqlUpStuParents);
while($row = mysql_fetch_array($exeUpStuParents)){
	$data = $row;
}

print json_encode($data);
	
?>