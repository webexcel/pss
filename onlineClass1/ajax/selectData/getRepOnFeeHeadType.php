<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

	
$data = json_decode(file_get_contents('php://input'), true);
/*foreach ($data as $key => $value ) {
	$arr = implode (", ", $value); 
}*/
$feeHeadTypeId	=	$data['feeHeadTypeId'];

$query	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_NO, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T4.feeType IN('".$feeHeadTypeId."') ";
//echo "SQL : " . $query . "\n";
$exeQuery	=	$mysqli->query($query);
$cnt		=	$exeQuery->num_rows;

$arr	=	array();
if( $cnt > 0 ) {
	while( $row = $exeQuery->fetch_assoc() ) {
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
	}
} else {
	$arr['status'] = 'No records found.';
	
}

echo json_encode($arr);
?>
	