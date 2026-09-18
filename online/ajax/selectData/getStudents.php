<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');


//$sqlSelStudents	=	" SELECT T1.StId AS ST_ID, T1.`ADMISSION_ID` AS ADNO, T1.`CLASS_ID`, T1.`NAME`, T1.`FATHER_NAME` AS FNAME, T1.`DOB`, T1.`Gender` AS GENDER,  T2.Standard AS STANDARD,  T2.Section AS SECTION, CONCAT(STANDARD, '-', SECTION) AS CLASS FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.CLASS_ID = T2.CLASS_ID WHERE T1.`stuStatus` = '1' AND T2.Status = '1' ORDER BY `T1`.`CLASS_ID`, T1.ADMISSION_ID, T1.NAME ASC " ;
$sqlSelStudents	=	" SELECT T1.`ADMISSION_ID` AS ADNO, T1.`CLASS_ID` , T1.`NAME` , T1.`FATHER_NAME` AS FNAME, T1.`DOB` , T2.Standard AS STANDARD, T2.Section AS SECTION, CONCAT( T2.Standard,  '-', T2.Section ) AS CLASS
FROM  `v_studentlist` T1
LEFT JOIN  `tbl_class` T2 ON T1.CLASS_ID = T2.CLASS_ID
WHERE T2.Status =  '1'
AND T1.`Year_Id` =  '1' ORDER BY `T1`.`CLASS_ID`, T1.ADMISSION_ID, T1.NAME ASC " ;
$exeSelStudents	=	$mysqli->query($sqlSelStudents);
$numSelStudents	=	$exeSelStudents->num_rows;

if( $numSelStudents > 0 ) {
	$arr	=	array();
	while( $row = $exeSelStudents->fetch_assoc() ) {
		
		
		$arr[]	=	$row;
	}
} else {
	$arr	=	array('error' => TRUE, 'message' => 'No results found. ');	
}


# JSON-encode the response
$json_response = json_encode($arr);

# Return the response
echo $json_response;


exit;


?>
	