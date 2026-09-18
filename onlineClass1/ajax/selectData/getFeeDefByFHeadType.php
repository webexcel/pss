<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

	
$data = json_decode(file_get_contents('php://input'), true);


if( isset($data) ) {

	$feeHeadTypeId	=	isset($data['feeHeadTypeId']) ? $data['feeHeadTypeId'] : '';
	//$feeClassId		=	isset($data['feeClassId']) ? $data['feeClassId'] : '';
	
//	if( $feeHeadTypeId != "" && $feeClassId !="" ) {
	//	$query	=	"SELECT DISTINCT(T1.`ADMISSION_ID`) AS ADMISSION_NO FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T4.feeType = '".$feeHeadTypeId."' AND T3.CLASS_ID = '".$feeClassId."' ";
	//} else if($feeHeadTypeId !="" && $feeClassId == "" ) {
		$query	=	"SELECT DISTINCT(T1.`ADMISSION_ID`) AS ADMISSION_NO FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T4.feeType = '".$feeHeadTypeId."' ";
	//} else if($feeHeadTypeId =="" && $feeClassId != "" ) {
		//$query	=	"SELECT DISTINCT(T1.`ADMISSION_ID`) AS ADMISSION_NO FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.CLASS_ID = '".$feeClassId."' ";
	//}
	
	//$query	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_NO, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T4.feeType = '".$feeHeadTypeId."' ";
	//$query	=	"SELECT DISTINCT(T1.`ADMISSION_ID`) AS ADMISSION_NO FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T4.feeType = '".$feeHeadTypeId."' ";
	//echo "SQL : " . $query . "\n";
	$exeQuery	=	$mysqli->query($query);
	$cnt		=	$exeQuery->num_rows;
	
	$arr	=	array();
	if( $cnt > 0 ) {
		while( $row = $exeQuery->fetch_assoc() ) {
			/*
			if( $row['RECEIPT_ID'] > 0 && $row['RECEIPT_ID'] < 9  ) {
				$recpid	=	"#000".$row['RECEIPT_ID'];
			} else if( $row['RECEIPT_ID'] > 10 && $row['RECEIPT_ID'] < 99  ) {
				$recpid	=	"#00".$row['RECEIPT_ID'];
			} else if( $row['RECEIPT_ID'] > 100 && $row['RECEIPT_ID'] < 999  ) {
				$recpid	=	"#0".$row['RECEIPT_ID'];
			} else {
				$recpid	=	"#".$row['RECEIPT_ID'];
			}
			$row['RECEIPT_ID']	=	$recpid;
			$arr[] = $row;
			*/
			
			$arr[]	=	$row['ADMISSION_NO'];
		}
		
		//$adno	=	implode(",",$arr);

		$adno = implode("','", $arr);
		$adno = "'".$adno."'";
		
		$query1		=	" SELECT T1.`ADMISSION_ID`, T1.`CLASS_ID`, T1.`NAME`, T1.`FATHER_NAME`, T1.`DOB`, T1.`Gender` AS GENDER, T2.`Standard` AS STANDARD, T2.`Section` AS SECTION FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.`CLASS_ID` = T2.`CLASS_ID`  WHERE T1.`ADMISSION_ID` NOT IN (".$adno.") ";
		//echo "SQL : " . $query1 . "\n";
		$exeQuery1	=	$mysqli->query($query1);
		$cnt1		=	$exeQuery1->num_rows;
		
		
		if( $cnt1 > 0 ) {
			$sno	=	0;
			while( $row1 = $exeQuery1->fetch_assoc() ) {			
				$sno++;
				$row1['SNO']	=	$sno;
				$arr1[]	=	$row1;
			}
			echo json_encode($arr1);			
			exit;
		} else {
			$arr['status'] = 'No records found.';
		}
		
	} else {
		$arr['status'] = 'No records found.';
	}
} else {
	$arr['status'] = 'No records found.';
}

echo json_encode($arr);
?>
	