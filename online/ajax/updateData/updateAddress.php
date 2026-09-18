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
$sqlUpStuAdd = "UPDATE `stu_address` SET $columnName ='$valuq' WHERE `ADMISSION_ID`='$ADMISSION_ID'";	

$exeUpStuAdd = mysql_query($sqlUpStuAdd);
while($row = mysql_fetch_array($exeUpStuAdd)){
	$data = $row;
}

print json_encode($data);
	
?>