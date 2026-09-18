<?php
require_once('../../login/auth.php');
require_once('../../login/config.php');
error_reporting(0);
	
$yearId	=	$_SESSION['YEAR_ID'];	
$data	=	array();

$_POST	=	json_decode(file_get_contents('php://input'), true);

$class_id	=	$_POST['name'];

@extract($_POST);

if( $class_id != "" ) {
	//$sql	=	" SELECT * FROM v_studentlist LEFT JOIN tbl_class ON v_studentlist.CLASS_ID = tbl_class.CLASS_ID WHERE v_studentlist.CLASS_ID='$class_id' ORDER BY v_studentlist.NAME ASC ";
	//$sql	=	" SELECT T1.`ADMISSION_ID`, T2.`rid`, T1.`rollNumber`, T2.`Standard`, T2.`Section`,  T1.`NAME`, T1.`FATHER_NAME`, T1.`Group`, T1.`IILanguage` FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.`CLASS_ID` = T2.`CLASS_ID` WHERE T2.`CLASS_ID` = '".$class_id."' ORDER BY T2.CLASS_ID, T1.`Group`, T1.`IILanguage`, T1.`NAME` ASC ";
	  echo $sql	=	"SELECT * from v_studentlist where Year_Id = '".$yearId."' AND CLASS_ID = '".$class_id."';"; 
	//$sql	=	" SELECT T1.`ADMISSION_ID`, T2.`rid`, T1.`rollNumber`, T2.`Standard`, T2.`Section`,  T1.`NAME`, T1.`FATHER_NAME`, T3.`groupName` AS GRP, T4.`langName` AS IILanguage FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.`CLASS_ID` = T2.`CLASS_ID` LEFT JOIN `tbl_group` T3 ON T3.`groupId` = T1.`Group` LEFT JOIN `tbl_2ndlanguage` T4 ON T4.`langId` = T1.`IILanguage` WHERE T2.`CLASS_ID` = '".$class_id."' AND `stuStatus` = '1' ORDER BY T2.CLASS_ID, T1.`Group`, T1.`IILanguage`, T1.`NAME` ASC ";
} else {
	//$sql	=	" SELECT T1.`ADMISSION_ID`, T2.`rid`, T1.`rollNumber`, T2.`Standard`, T2.`Section`,  T1.`NAME`, T1.`FATHER_NAME`, T1.`Group`, T1.`IILanguage` FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.`CLASS_ID` = T2.`CLASS_ID` WHERE 1 ORDER BY T2.CLASS_ID, T1.`Group`, T1.`IILanguage`, T1.`NAME` ASC ";
	echo  $sql  =	" SELECT * from v_studentlist where Year_Id = '".$yearId."'; ";
	//$sql	=	" SELECT T1.`ADMISSION_ID`, T2.`rid`, T1.`rollNumber`, T2.`Standard`, T2.`Section`,  T1.`NAME`, T1.`FATHER_NAME`, T3.`groupName` AS GRP, T4.`langName` AS IILanguage FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.`CLASS_ID` = T2.`CLASS_ID` LEFT JOIN `tbl_group` T3 ON T3.`groupId` = T1.`Group` LEFT JOIN `tbl_2ndlanguage` T4 ON T4.`langId` = T1.`IILanguage` WHERE  `stuStatus` = '1' ORDER BY T2.`CLASS_ID`, T1.`Group`, T1.`IILanguage`, T1.`NAME` ASC ";
}


$exesql = mysql_query($sql);

while($row = mysql_fetch_array($exesql)){
	$rid	=	$row['rid'];
	$rolNo	=	$row['rollNumber'];
	//$row['rollNumber']	=	$rid.sprintf("%'.02d\n", $row['rollNumber']);
	if( $rolNo < 10) {
		$rolNo	=	"0".$row['rollNumber'];
	}
	$row['rollNumber']	=	$rid.$rolNo;
	
	$data[] = $row;
}

print json_encode($data);
	
	
?>
	