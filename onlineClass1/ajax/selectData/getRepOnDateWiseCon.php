<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);

$dateFrom	=	date("Y-m-d", strtotime($data['dateFrom2']));
$dateTo		=	date("Y-m-d", strtotime($data['dateTo2']));
$yearId	    =	$_SESSION['YEAR_ID'];

$sqlFeeHistory	=	"SELECT T1.ADMISSION_ID AS ADMISSION_ID, T1.NAME, T1.Group,T3.RECEIPT_ID, T3.RECEIPT_NO AS RECEIPT_NO, T1.Standard AS STANDARD, T1.Section AS SECTION, T3.RECEIPT_NO, T3.RECEIPT_DATE, sum(T4.Amount) AS FEE_AMOUNT FROM `v_studentlist` T1 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 ON T1.CLASS_ID = T3.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' AND T3.STATUS = '0' AND T3.Year_Id = '".$yearId."' GROUP BY T1.ADMISSION_ID  ORDER BY T1.NAME ASC, T3.RECEIPT_ID ASC " ;
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;


$arr	=	array();
if( $cntFeeHistory > 0 ) {

	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHis	=	[];
		if( $row['RECEIPT_ID'] >= 0 && $row['RECEIPT_ID'] <= 9  ) {
			$recpid	=	"#000".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] >= 10 && $row['RECEIPT_ID'] <= 99  ) {
			$recpid	=	"#00".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] >= 100 && $row['RECEIPT_ID'] <= 999  ) {
			$recpid	=	"#0".$row['RECEIPT_ID'];
		} else {
			$recpid	=	"#".$row['RECEIPT_ID'];
		}
		
		$row['RECEIPT_ID']			=	$recpid;
		
		//$row['DATE']				=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		if($row['RECEIPT_DATE'] != '0000-00-00') {
			$row['DATE']	=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		} else {
			$row['DATE']	=	"00-00-0000";
		}
		$arr[]	=	$row;
	}

}

$json_response = json_encode($arr);

// # Return the response
echo $json_response;
exit;



?>