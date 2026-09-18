<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
	
/* 	$data = array();
 //Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

$class=$_POST['name'];
$adno=$_POST['adno'];
@extract($_POST); */

/* if($class!=""){ 
	$abslist = "SELECT * FROM v_studentlist WHERE v_studentlist.ADMISSION_ID NOT IN (SELECT feesreceipt.ADMISSION_ID FROM feesreceipt) AND `CLASS_ID` ='$class'";}*/
	$abslist = "SELECT CONCAT(Standard,' - ',Section) as clas, ADMISSION_ID, rollNumber, CONCAT(NAME,' ',FATHER_NAME) as StudentName  FROM v_studentlist WHERE v_studentlist.ADMISSION_ID NOT IN (SELECT feesreceipt.ADMISSION_ID FROM feesreceipt)";
	$abslistexe = mysql_query($abslist);
	while($row = mysql_fetch_assoc($abslistexe)){
	$data[] = $row;
 	}
	print json_encode($data);
	
	
	?>