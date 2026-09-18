<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);


$from_date	=	date("Y-m-d", strtotime($data['from_date']));
$to_date	=	date("Y-m-d", strtotime($data['to_date']));


//$sqlFeeHistory	=	"SELECT ADMISSION_ID, CLASS_ID, transId AS FEE_REC_DET_ID, tA.RECEIPT_ID, RECEIPT_DATE, Amount AS FEE_AMOUNT, tC.feehead AS FEE_HEAD, tD.FeeType AS FEE_TYPE FROM `fee_receipt` tA LEFT JOIN  fee_transanction tB ON tA.RECEIPT_ID = tB.RECEIPT_ID LEFT JOIN feeheads tC ON tB.feeHead = tC.feeheadId JOIN feetype tD ON tB.feeType = tD.FeeTypeId WHERE tA.RECEIPT_DATE BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY tA.RECEIPT_DATE DESC ";
$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_NO, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_DATE BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY T3.RECEIPT_DATE DESC ";
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

$json_response = json_encode($newArr1);

// # Return the response
echo $json_response;

exit;



?>