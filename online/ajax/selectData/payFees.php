<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
	
	$data = array();
 //Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

$class=$_POST['name'];
$adno=$_POST['adno'];
@extract($_POST);

if($class!=""){
	   //$abslist = "SELECT student_info1.ADMISSION_ID, tbl_class.Standard, tbl_class.Section, student_info1.CLASSSEC, student_info1.Type, student_info1.CLASS_ID, student_info1.NAME, student_info1.FATHER_NAME, feesreceipt.ReceiptID, feesreceipt.period, feesreceipt.rec_date FROM student_info1 LEFT JOIN feesreceipt ON student_info1.ADMISSION_ID = feesreceipt.ADMISSION_ID LEFT JOIN tbl_class ON student_info1.CLASS_ID = tbl_class.CLASS_ID WHERE student_info1.CLASS_ID='$class'";	
		$abslist = "SELECT *,v_studentlist.ADMISSION_ID, feesreceipt.ReceiptID, feesreceipt.period, feesreceipt.rec_date FROM v_studentlist LEFT JOIN feesreceipt ON v_studentlist.ADMISSION_ID = feesreceipt.ADMISSION_ID WHERE v_studentlist.CLASS_ID='$class' ORDER BY feesreceipt.ReceiptID";}
	
if($adno!=""){
		$abslist = "SELECT *,v_studentlist.ADMISSION_ID, feesreceipt.ReceiptID, feesreceipt.period, feesreceipt.rec_date FROM v_studentlist LEFT JOIN feesreceipt ON v_studentlist.ADMISSION_ID = feesreceipt.ADMISSION_ID WHERE v_studentlist.ADMISSION_ID='$adno'";	
		}
	
	$abslistexe = mysql_query($abslist);
	while($row = mysql_fetch_array($abslistexe)){
	$data[] = $row;
	}
	print json_encode($data);
	
	
	?>