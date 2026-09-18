<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);


$dateFrom	=	date("Y-m-d", strtotime($data['dateFrom2']));
$dateTo		=	date("Y-m-d", strtotime($data['dateTo2']));
$yearId	    =	$_SESSION['YEAR_ID'];


//$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_ID, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T6.FeeType AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 JOIN feetype T6 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId AND T4.feeType = T6.FeeTypeId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' ORDER BY T1.NAME ASC, T3.RECEIPT_ID ASC " ;
$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_ID, T1.`NAME`, T1.`FATHER_NAME`, T1.Standard AS STANDARD, T1.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_NO, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T5.feetype AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM `v_studentlist` T1 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 ON T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.YEAR_ID = '".$yearId."' AND T3.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' ORDER BY T1.NAME ASC, T3.RECEIPT_ID ASC " ;
//$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_ID, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T1.Group AS SGROUP, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_NO, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T5.feetype AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM `v_studentlist` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' ORDER BY T1.NAME ASC, T3.RECEIPT_ID ASC " ;
//echo "SQL : " . $sqlFeeHistory . "<br />";
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;


$arr	=	array();
if( $cntFeeHistory > 0 ) {

	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHis	=	[];
		if( $row['RECEIPT_NO'] >= 0 && $row['RECEIPT_NO'] <= 9  ) {
			$recpid	=	"#000".$row['RECEIPT_NO'];
		} else if( $row['RECEIPT_NO'] >= 10 && $row['RECEIPT_NO'] <= 99  ) {
			$recpid	=	"#00".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_NO'] >= 100 && $row['RECEIPT_NO'] <= 999  ) {
			$recpid	=	"#0".$row['RECEIPT_NO'];
		} else {
			$recpid	=	"#".$row['RECEIPT_NO'];
		}
		
		$row['RECEIPT_NO']			=	$recpid;
		
		if($row['RECEIPT_DATE'] != '0000-00-00') {
			$row['DATE']	=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		} else {
			$row['DATE']	=	"00-00-0000";
		}
		
		$arr[]	=	$row;
	}

}
//$json_response = json_encode($arr);

// # Return the response
//echo $json_response;
//exit;


$newarr	=	[];
foreach($arr as $item) {
	//$adno	=	$item['ADMISSION_ID'];	
	//$newarr[$adno][] = $item;
	
	$adno	=	$item['ADMISSION_ID'];
	$newarr[$adno][] = $item;
	
}


$rarr	=	array();
foreach( $newarr as $key => $val ) {
	$kadno	=	$key;
	
	$amount	= 0;
	foreach($val as $item) {
		$sArr	=	array(
						'ADMISSION_ID' => $item['ADMISSION_ID'],
						'RECEIPT_ID' => $item['RECEIPT_ID'],
						'RECEIPT_NO' => $item['RECEIPT_NO'],
						'NAME' => $item['NAME'],
						'FATHER_NAME' => $item['FATHER_NAME'],
						'GENDER' => $item['GENDER'],
						'SGROUP' => $item['SGROUP'],
						'STANDARD' => $item['STANDARD'],
						'SECTION' => $item['SECTION']
					);
		$amount	+=	$item['FEE_AMOUNT'];
					
	}
	$sArr['AMOUNT'] = $amount;
	
	array_push($rarr, $sArr);
}





//print_r($rarr);


$json_response = json_encode($rarr);

// # Return the response
echo $json_response;
exit;




?>