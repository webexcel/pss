<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);
$billname	= 	$data['billname'];
$yearId	    =	$_SESSION['YEAR_ID'];
$dateFrom	=	date("Y-m-d", strtotime($data['dateFrom']));
$dateTo		=	date("Y-m-d", strtotime($data['dateTo']));

$sqlFeeHistory	= " SELECT T1.ADMISSION_ID , T1.NAME , T1.CLASSSEC ,T2.RECEIPT_NO, T2.RECEIPT_DATE AS DATE, SUM( T3.Amount ) AS TOTAL
FROM  v_studentlist T1
JOIN fee_receipt T2 ON T1.ADMISSION_ID = T2.ADMISSION_ID 
JOIN fee_transanction T3 ON T2.RECEIPT_ID = T3.RECEIPT_ID and T2.Year_Id = T3.Year_Id
WHERE T2.billBookName =  '".$billname."' AND 
T2.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' AND T2.STATUS = '0' AND T1.YEAR_ID = '".$yearId."' AND T2.YEAR_ID = '".$yearId."' AND T3.YEAR_ID = '".$yearId."'
GROUP BY T1.ADMISSION_ID";

$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;
$totpaid = 0;
$arr	=	array();
if( $cntFeeHistory > 0 ) {

	while($row = $exeFeeHistory->fetch_assoc()) {
		$narr = array();
		$narr['ADMISSION_ID']		=	$row['ADMISSION_ID'];
		$narr['CLASSSEC']			=	$row['CLASSSEC'];
		$narr['NAME']	    		=	$row['NAME']; 
		$narr['RECEIPT_NO']	    	=	$row['RECEIPT_NO'];
		$narr['RECEIPT_DATE']	    =	$row['DATE'];
		$narr['TOTAL']				=	$row['TOTAL'];
		
		$totpaid	+= $narr['TOTAL'];
		$arr []=	$narr;
	}
}
$tarr = array_merge(array('result'=>$arr), array('TOTAL' => $totpaid));
$json_response = json_encode($tarr);
echo $json_response;
exit;
?>