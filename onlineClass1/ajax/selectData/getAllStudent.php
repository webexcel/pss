<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data   =   json_decode(file_get_contents('php://input'), true);


if( isset($data['section']) ) {
	$section	=	trim($data['section']);
} else {
	$section	=	"";
}
$yearId		=	$_SESSION['YEAR_ID'];

if( $section == "" ) {
	$query	=	" SELECT *,T2.IILanguage from v_studentlist T1 join student_info1 T2 on T2.ADMISSION_ID = T1.ADMISSION_ID where T1.Year_Id = '".$yearId."'; ";
	//exit();
	//$query	=	" SELECT T1.StId AS ST_ID, T1.`ADMISSION_ID`, T1.`CLASS_ID`, T1.`NAME`, T1.`FATHER_NAME`, T1.`DOB`, T1.`Gender` AS GENDER,  T2.Standard AS STANDARD,  T2.Section AS SECTION, T3.EMISNumber AS EMIS_NO FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.CLASS_ID = T2.CLASS_ID LEFT JOIN stu_others T3 ON T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T1.`stuStatus` = '1' AND T2.Status = '1' ORDER BY `T1`.`CLASS_ID`, T1.ADMISSION_ID, T1.NAME ASC";
} else {
	//$query	=	" SELECT T2.`CLASS_ID`, T2.Standard AS STD, T2.Section AS SEC, T1.`NAME`, T1.`FATHER_NAME`, T1.`ADMISSION_ID` FROM student_info1 T1 LEFT JOIN tbl_class T2 ON T1.CLASS_ID = T2.CLASS_ID WHERE T1.ADMISSION_ID IN (SELECT DISTINCT(ADMISSION_ID) FROM `fee_receipt` WHERE STATUS = 0 AND YEAR_ID = '".$yearId."') AND T2.CLASS_ID = '".$section."' ORDER BY T1.CLASS_ID, T1.NAME ";
	$query	=	" SELECT *,T2.IILanguage from v_studentlist T1 join student_info1 T2 on T1.ADMISSION_ID = T2.ADMISSION_ID  where T1.Year_Id = '".$yearId."' AND T1.CLASS_ID = '".$section."'; ";
	}


//echo $query;
$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		$arr[]		=	$row;
	}
}


$json_response = json_encode($arr);

echo $json_response;

exit;





?>
	