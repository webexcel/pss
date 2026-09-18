<?php
require_once('../../login/auth.php');
//Include database connection details
require_once('../../login/config.php');
error_reporting(0);
session_start();

//$data = array();
 //Getting posted data and decodeing json

$_POST   =   json_decode(file_get_contents('php://input'), true);

foreach ($_POST as $key => $value )
{
	$data = explode('|', $value);
	$columnName = $key;
	$valuq = $value;
}
$yearId	    =	$_SESSION['YEAR_ID'];
$ADMISSION_ID = $_POST['ADMISSION_ID'];
if($columnName == 'CLASS_ID')
{
	 $qry = "UPDATE `student_class_map` SET `class_id` ='".$valuq."' WHERE `ADMISSION_NO`='".$ADMISSION_ID."' AND `Year_Id` = '$yearId'";
	 mysql_query($qry) OR die("Error:".mysql_error());
} 
	
	
	//$abslist = "UPDATE `student_info1` SET `$columnName` ='$valuq' WHERE `ADMISSION_ID`='$ADMISSION_ID' AND `Year_Id` = '$yearId'";	
	$abslist = "UPDATE `student_info1` SET `$columnName` ='$valuq' WHERE `ADMISSION_ID`='$ADMISSION_ID'";	
	$abslistexe = mysql_query($abslist);
	
	while($row = mysql_fetch_array($abslistexe)){
		$data = $row;
	}


	print json_encode($data);
	?>