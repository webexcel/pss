<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$adno	=	isset($data['adno']) ? $data['adno'] : '';

if($adno == '') {
	$res['status'] = 'error while geting records...!';
	
	$json_response = json_encode($arr);
	echo $json_response;

	exit;
}


$sqlFeeDetails	=	"SELECT fee.CLASS_ID, fee.feeheadId, fee.FeeHead, fee.feetypeid, fee.FeeType,
IFNULL(tran.TOT_AMOUNT,0) as PAID_FEE,
IFNULL(fee.feeamount,0) as TOTAL_FEE, (fee.feeamount -  IFNULL( TOT_AMOUNT , 0)) as REMAINING_FEE
FROM v_fees fee   LEFT OUTER JOIN v_feestrans tran
ON fee.feeHeadId = tran.feeHeadId  AND fee.CLASS_ID = tran.CLASS_ID 
AND tran.Admission_Id =  '".$adno."'
WHERE Fee.Class_ID  IN (SELECT Class_ID FROM student_info1 WHERE Admission_Id =  '".$adno."' ) ";

//echo "SQL : " . $sqlFeeDetails . "<br />";

$exeFeeDetails	=	$mysqli->query($sqlFeeDetails);
$cntFeeDetails	=	$exeFeeDetails->num_rows;

if( $cntFeeDetails > 0 ) {
	$feeamounttotal = 0;
	while( $row = $exeFeeDetails->fetch_assoc() ) {
		
		$arrFeeDetails = array();
		$arrFeeDetails['FEE_HEAD_ID']	= $row['feeheadId'];
		$arrFeeDetails['FEE_TYPE_ID']	= $row['feetypeid'];			
		$arrFeeDetails['FEE_HEAD'] 		= $row['feehead'];
		$arrFeeDetails['FEE_TYPE'] 		= $row['feetype'];
		$arrFeeDetails['TOTAL_FEE'] 	= $row['TOTAL_FEE'];
		$arrFeeDetails['PAID_FEE'] 		= $row['PAID_FEE'];
		$arrFeeDetails['REMAINING_FEE'] = $row['REMAINING_FEE'];
		
		$arr['FEES'][] = $arrFeeDetails;
	}
}

/*$sqlFeeConcession	=	"SELECT SUM(`CONCESSION_AMOUNT`) AS CONCESSION_AMOUNT FROM `fee_concession` WHERE `ADMISSION_ID` = '".$adno."' ";
$exeFeeConcession	=	$mysqli->query($sqlFeeConcession);
$resFeeConcession	=	$exeFeeConcession->fetch_assoc();
$arr['CONCESSION']['AMOUNT'] = $resFeeConcession['CONCESSION_AMOUNT'];
*/

$json_response = json_encode($arr);
echo $json_response;

exit;

?>
	