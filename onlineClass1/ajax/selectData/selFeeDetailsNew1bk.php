<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
require_once('../function.php');

session_start();


$_POST	=	json_decode(file_get_contents('php://input'), true);

//$yearId	=	$_SESSION['YEAR_ID'];

$adno = $_POST['adno'];
$billBookId = $_POST['billBookId'];
$query	=	" SELECT `CLASS_ID`, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `Standard` AS STD, `Section` AS SEC, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` WHERE `ADMISSION_ID` = '".$adno."' ";
$result	=	$mysqli->query($query);


$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$arrFeeDetails = array();
		$sno++;
		$row['sno']	=	$sno;
		//$arr[]		=	$row;
		$arr['ADNO']		=	$row['ADMISSION_ID'];
		$arr['CLASS_ID']	=	$row['CLASS_ID'];
		$arr['NAME']		=	$row['NAME'];
		$arr['FATHER_NAME']	=	$row['FATHER_NAME'];
		$arr['SECTION']		=	$row['CLASS_SECTION'];
		$arr['STD']			=	$row['STD'];
		$arr['SEC']			=	$row['SEC'];
		$arr['CURR_DATE']	=	date("d-m-Y");
		$arr['U_PDF']		=	$_SESSION['SESS_MEMBER_DBNAME'];

		
		
	}
}
$sql_feehead = "SELECT * FROM tbl_bill where `status` = '1'  ";
$exeFee	=	$mysqli->query($sql_feehead);
$arrayfee = array();
	while( $row = $exeFee->fetch_assoc() ) {
		$arrayfee['billtypes'][] = $row;
	}
/*
$sqlFeeDetails	=	"SELECT fee.CLASS_ID, fee.feeheadId, fee.feehead, fee.feetype, fee.interval, fee.instalment, feestatus .*,
IFNULL(tran.TOT_AMOUNT, 0) as PAID_FEE,
IFNULL(fee.feeamount, 0) as TOTAL_FEE, (fee.feeamount -  IFNULL( TOT_AMOUNT , 0)) as REMAINING_FEE
FROM v_fees fee   LEFT OUTER JOIN v_feestrans tran
ON fee.feeHeadId = tran.feeHeadId  AND fee.CLASS_ID = tran.CLASS_ID 
AND tran.Admission_Id =  '".$arr['ADNO']."' JOIN feestatus ON fee.feeHeadId = feestatus.Fee_Headid
WHERE Fee.Class_ID  IN (SELECT Class_ID FROM student_info1 WHERE Admission_Id =  '".$arr['ADNO']."' ) AND feestatus.Admission_Id = '".$arr['ADNO']."' AND fee.billBookId = '".$billBookId."' AND fee.Year_Id ='".$_SESSION['YEAR_ID']."'";

*/
$sqlFeeDetails	=	"SELECT fee.CLASS_ID, fee.feeheadId, fee.feehead, fee.feetype, fee.interval, fee.instalment, feestatus .*,
IFNULL(tran.TOT_AMOUNT, 0) as PAID_FEE,
IFNULL(fee.feeamount, 0) as TOTAL_FEE, (fee.feeamount -  IFNULL( TOT_AMOUNT , 0)) as REMAINING_FEE
FROM v_fees fee   LEFT OUTER JOIN v_feestrans tran
ON fee.feeHeadId = tran.feeHeadId  AND fee.CLASS_ID = tran.CLASS_ID 
AND tran.Admission_Id =  '".$arr['ADNO']."' JOIN feestatus ON fee.feeHeadId = feestatus.Fee_Headid
WHERE Fee.Class_ID  IN (SELECT Class_ID FROM student_info1 WHERE Admission_Id =  '".$arr['ADNO']."' ) AND feestatus.Admission_Id = '".$arr['ADNO']."' AND fee.billBookId = '".$billBookId."'";



//echo "SQL : " . $sqlFeeDetails . "<br />";

$exeFeeDetails	=	$mysqli->query($sqlFeeDetails);
$cntFeeDetails	=	$exeFeeDetails->num_rows;

if( $cntFeeDetails > 0 ) {
	$feeamounttotal = 0;
	$arrT1	=	array();
	$arrT1['TOT_AMOUNT'] = 0;
	while( $row = $exeFeeDetails->fetch_assoc() ) {
		$arrFeeDetails = array();
		$arrFeeDetails['FEE_HEAD_ID']	= $row['feeheadId'];		
		$arrFeeDetails['FEE_HEAD'] 		= $row['feehead'];
		$arrFeeDetails['FEE_TYPE'] 		= $row['feetype'];
		$arrFeeDetails['TOTAL_FEE'] 	= $row['TOTAL_FEE'];
		$arrFeeDetails['PAID_FEE'] 		= $row['PAID_FEE'];
		$arrFeeDetails['TOTAL_REMAINING'] = $row['REMAINING_FEE'];
				
	/////////////////////// Concession starts Here/////////////////////////////////////////////////	
		$sqlCon	=	" SELECT sum(CONCESSION_AMOUNT) AS CONCESSION_AMOUNT FROM fee_concession WHERE CONCESSION_FEE_HEAD_ID = '".$row['feeheadId']."' AND ADMISSION_ID = '".$arr['ADNO']."' AND CONCESSION_STATUS = '' " ;
		$exeCon	=	$mysqli->query($sqlCon);
		$resCon	=	$exeCon->fetch_assoc();
		$conce	=	$resCon['CONCESSION_AMOUNT'];

		if( $conce != '') {
			$arrFeeDetails['CONCESSION_AMOUNT'] = $resCon['CONCESSION_AMOUNT'];
		} else {
			$arrFeeDetails['CONCESSION_AMOUNT'] = 0;
		}
	////////////////////////////////////////////////////////////////////////////////////////	
		
		$arrFeeDetails['FSID']			=	$row['FSID'];
		$interval						=	$row['interval'];
		$instalment						=	$row['instalment'];
		$lPaid							=	$row['Paid_Period'];
		$type							=	$row['feetype'];
		$preBalance						=	$row['Balance_Amount'];
		//$preBalance						=	$row['Balance_Amount'] - $arrFeeDetails['CONCESSION_AMOUNT'];
		
		$asOfNowBalance					=	calBalance($type, $lPaid, $interval, $instalment, $preBalance);
		
		if($arrFeeDetails['FEE_TYPE'] == 'PENDING') {
			$arrFeeDetails['TOTAL_FEE']		=	$arrFeeDetails['PAID_FEE'] + $asOfNowBalance;
		}
		
		$arrFeeDetails['INTERVAL']		=	$interval;
		$arrFeeDetails['INSTALMENT']	=	$instalment;
		$arrFeeDetails['LAST_PAID']		=	$lPaid;
		$arrFeeDetails['PRE_BALANCE']	=	$preBalance;
		$arrFeeDetails['AS_OF_AMOUNT'] =	$asOfNowBalance - $arrFeeDetails['CONCESSION_AMOUNT'];
		$arr1['FEE_DETAILS'][] = $arrFeeDetails;
		$arrT1['TOT_AMOUNT']	+= $row['TOTAL_FEE'];
	}
	
	$arr =	array_merge($arr, $arrayfee);
	$arr =	array_merge($arr, $arrT1);
	$arr =	array_merge($arr, $arr1);
	
}


$sqlFeeHistory	=	"SELECT ADMISSION_ID, CLASS_ID, transId AS FEE_REC_DET_ID, tA.RECEIPT_ID, RECEIPT_DATE, Amount AS FEE_AMOUNT, tC.feehead AS FEE_HEAD, tC.feetype AS FEE_TYPE FROM `fee_receipt` tA LEFT JOIN  fee_transanction tB ON tA.RECEIPT_ID = tB.RECEIPT_ID LEFT JOIN feeheads tC ON tB.feeHead = tC.feeheadId WHERE tA.STATUS = '0' AND tA.ADMISSION_ID = '".$arr['ADNO']."' AND tA.CLASS_ID = '".$arr['CLASS_ID']."' ORDER BY tA.RECEIPT_ID DESC ";
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;

if( $cntFeeHistory > 0 ) {
	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHistory = array();
		
		$arrFeeHis['FEE_REC_DET_ID']	=	$row['FEE_REC_DET_ID'];
		$arrFeeHis['RECPID']			=	$row['RECEIPT_ID'];
		$arrFeeHis['FEE_HEAD']			=	$row['FEE_HEAD'];
		$arrFeeHis['FEE_TYPE']			=	$row['FEE_TYPE'];
		$arrFeeHis['DATE']				=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		$arrFeeHis['PAID_AMOUNT']		=	$row['FEE_AMOUNT'];
		
		$arr2[] = $arrFeeHis;
		$arrT2['TOT_HISTORY'] += $row['FEE_AMOUNT'];
	}
	$newArr	=	[];
	foreach( $arr2 as $key => $value ) {
		$receiptid	=	$value['RECPID'];
		$newArr['FEE_HISTORY'][$receiptid][] = $value;
	}
	$arr	=	array_merge($arr, $arrT2);
	$arr	=	array_merge($arr, $newArr);
}
$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;
	

?>