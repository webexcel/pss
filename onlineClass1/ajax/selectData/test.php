<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
//$result = mysql_query("SELECT `ADMISSION_ID`, `NAME`, `FATHER_NAME`, `MotherName`, `DOB`, `rollNumber`, `Gender`, `DOJ`, `Religion`, `Caste`, `MotherTongue` ,`Height`, `Weight` FROM student_info1 LEFT join tbl_class ON student_info1.CLASS_ID=tbl_class.CLASS_ID");
$result = mysql_query("SELECT * FROM student_info1");
while($row = mysql_fetch_assoc($result)) {
	
	$classsec[] = $row;
}

	print json_encode($classsec);
	


	?>