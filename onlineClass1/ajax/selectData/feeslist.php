<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
	
	$data = array();
 //Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

$adno=$_POST['adno'];
//$adno = "17773";

if($adno!=""){
	   $abslist = "SELECT *, student_info1.CLASSSEC FROM v_studentlist LEFT JOIN feesreceipt ON v_studentlist.ADMISSION_ID = feesreceipt.ADMISSION_ID LEFT JOIN student_info1 ON student_info1.ADMISSION_ID = feesreceipt.ADMISSION_ID WHERE feesreceipt.ADMISSION_ID = '$adno'";	
	}

	$abslistexe = mysql_query($abslist);
	while($row = mysql_fetch_assoc($abslistexe)){
	$data[] = $row;
	}
	print json_encode($data);
	
	
	?>
	