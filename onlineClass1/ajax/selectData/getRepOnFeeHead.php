<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();
	
$data = json_decode(file_get_contents('php://input'), true);

$dateFrom	=	date("Y-m-d", strtotime($data['dateFrom']));
$dateTo		=	date("Y-m-d", strtotime($data['dateTo']));
$feeHeadId	=	implode (",", $data['headId']); 
$yearId	    =	$_SESSION['YEAR_ID'];



$query	= "SELECT T1.ADMISSION_ID , T1.NAME , T1.CLASSSEC ,T2.RECEIPT_NO as RECEIPT ,T4.feehead as HEADNAME, T3.Amount AS AMOUNT
FROM  v_studentlist T1
JOIN fee_receipt T2 ON T1.ADMISSION_ID = T2.ADMISSION_ID 
JOIN fee_transanction T3 ON T2.RECEIPT_ID = T3.RECEIPT_ID JOIN feeheads T4 ON T3.feeHead = T4.feeheadId
WHERE T2.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' AND T2.YEAR_ID = '".$yearId."' and T1.Year_Id = '".$yearId."' AND T3.feeHead IN ($feeHeadId)";

$exeQuery	=	$mysqli->query($query);
$cnt		=	$exeQuery->num_rows;

$arr	=	array();
if( $cnt > 0 ) {
	while( $row = $exeQuery->fetch_assoc() ) {
		$arr[] = $row;
	}
}
echo json_encode($arr);
exit;
?>
	