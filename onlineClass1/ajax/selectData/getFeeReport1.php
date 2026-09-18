<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);

$feeHeadId = implode(',', $data);

$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_NO, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T4.feeHead IN('".$feeHeadId."') ";
//echo "SQL : " . $sqlFeeHistory . "<br />";
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;


$arr	=	array();
if( $cntFeeHistory > 0 ) {

	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHis	=	[];
		$arrFeeHis['ADMISSION_NO']		=	$row['ADMISSION_NO'];
		$arrFeeHis['NAME']				=	$row['NAME'];
		$arrFeeHis['FATHER_NAME']		=	$row['FATHER_NAME'];
		$arrFeeHis['GENDER']			=	$row['GENDER'];
		$arrFeeHis['STANDARD']			=	$row['STANDARD']. "-" .$row['SECTION'];
		
		if( $row['RECEIPT_ID'] > 0 && $row['RECEIPT_ID'] < 9  ) {
			$recpid	=	"#000".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] > 10 && $row['RECEIPT_ID'] < 99  ) {
			$recpid	=	"#00".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] > 100 && $row['RECEIPT_ID'] < 999  ) {
			$recpid	=	"#0".$row['RECEIPT_ID'];
		} else {
			$recpid	=	"#".$row['RECEIPT_ID'];
		}
		
		$arrFeeHis['RECPID']			=	$recpid;
		
		$arrFeeHis['DATE']				=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		$arrFeeHis['FEE_AMOUNT']		=	$row['FEE_AMOUNT'];
		
		$arr[]	=	$arrFeeHis;
	}

}
/*
$newArr	=	array();
$newArr1 = array();
foreach( $arr as $key => $value ) {
	$newArr2 = array();
	$receiptid	=	$value['RECPID'];
	$newArr[$receiptid]['ADMISSION_NO']	=	$value['ADMISSION_NO'];
	$newArr[$receiptid]['NAME']			=	$value['NAME'];
	$newArr[$receiptid]['FATHER_NAME']	=	$value['FATHER_NAME'];
	$newArr[$receiptid]['GENDER']		=	$value['GENDER'];
	$newArr[$receiptid]['STANDARD']		=	$value['STANDARD'];
	
	$newArr[$receiptid]['RECPID']		=	$value['RECPID'];
	$newArr[$receiptid]['DATE']			=	$value['DATE'];
	$newArr[$receiptid]['AMOUNT']		+=	$value['FEE_AMOUNT'];

}

foreach( $newArr as $items ) {
	array_push($newArr1, $items);
}
*/

$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>