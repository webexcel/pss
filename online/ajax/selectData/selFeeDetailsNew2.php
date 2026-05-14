<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../configi.php');
session_start();


$_POST	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	$_SESSION['yearid'];
$adno = $_POST['adno'];

$query	=	" SELECT `CLASS_ID`, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `Standard` AS STD, `Section` AS SEC, `NAME`, `FATHER_NAME`, `ADMISSION_ID`,`contact`,`Year_Id` FROM `v_studentlist` WHERE `ADMISSION_ID` = '".$adno."' and `Year_Id` = '".$yearId."'";
$result	=	mysqli_query($dbconnect, $query);
$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$arrFeeDetails = array();
		$sno++;
		$row['sno']	=	$sno;
		$arr['ADNO'] =	$row['ADMISSION_ID'];
		$arr['CLASS_ID'] =	$row['CLASS_ID'];
		$arr['NAME']		=	$row['NAME'];
		$arr['FATHER_NAME']	=	$row['FATHER_NAME'];
		$arr['SECTION']		=	$row['CLASS_SECTION'];
		$arr['STD']			=	$row['STD'];
		$arr['SEC']			=	$row['SEC'];
		$arr['contact']		=	$row['contact'];
		$arr['Year_Id']		=	$row['Year_Id'];
		$arr['CURR_DATE']	=	date("d-m-Y");	
	}
}


	
$sqlFeeDetails	=	"SELECT fh.`interval`,
  SUM(fs.Balance_Amount) AS Balance_Amount,
  IFNULL(SUM(ft.TOT_AMOUNT), 0) AS PAID_FEE,
  IFNULL(SUM(fgm.feeAmount), 0) AS TOTAL_FEE,
  (IFNULL(SUM(fgm.feeAmount), 0) - IFNULL(SUM(ft.TOT_AMOUNT), 0)) AS REMAINING_FEE,
  scm.class_id
FROM feegroupmapping fgm
JOIN feeheads fh
  ON fgm.FeeHeadId = fh.feeheadId
JOIN student_class_map scm
  ON fgm.FeeGrpID = scm.feeGrpId AND fgm.Year_Id = scm.Year_Id LEFT JOIN ( SELECT feeHeadId, CLASS_ID, Admission_Id, SUM(TOT_AMOUNT) AS TOT_AMOUNT FROM v_feestrans 
WHERE Admission_Id = '".$adno."' GROUP BY feeHeadId, CLASS_ID, Admission_Id) ft ON fgm.FeeHeadId = ft.feeHeadId AND scm.class_id = ft.CLASS_ID AND ft.Admission_Id = '".$adno."' 
JOIN (SELECT Fee_Headid, Year_Id, Admission_Id, SUM(Balance_Amount) AS Balance_Amount FROM feestatus   WHERE Admission_Id = '".$adno."' AND Year_Id = '".$yearId."' 
GROUP BY Fee_Headid, Year_Id, Admission_Id) fs ON fgm.FeeHeadId = fs.Fee_Headid   AND fgm.Year_Id = fs.Year_Id WHERE scm.Admission_No = '".$adno."'   AND fgm.Year_Id = '".$yearId."' GROUP BY fh.`interval`, scm.class_id";

$exeFeeDetails	=	mysqli_query($dbconnect, $sqlFeeDetails);
	$cntFeeDetails	=	$exeFeeDetails->num_rows;

if( $cntFeeDetails > 0 ) {
	$feeamounttotal = 0;
	$arrT1	=	array();
	$arrT1['TOT_AMOUNT'] = 0;
	while( $row = $exeFeeDetails->fetch_assoc() ) {
		$arrFeeDetails = array();
		/*$arrFeeDetails['FEE_HEAD_ID']	= $row['feeheadId'];		
		$arrFeeDetails['FEE_HEAD'] 		= $row['feehead'];
		$arrFeeDetails['FEE_GROUP'] 	= $row['GroupId'];
		$arrFeeDetails['FEE_TYPE'] 		= $row['feetype'];
		$arrFeeDetails['TOTAL_FEE'] 	= $row['TOTAL_FEE'];
		$arrFeeDetails['PAID_FEE'] 		= $row['PAID_FEE'];
		$arrFeeDetails['TOTAL_REMAINING'] = $row['REMAINING_FEE'];				
		$arrFeeDetails['FSID']			=	$row['FSID'];*/
		$asOfNowBalance					=	$row['Balance_Amount'];
		/*if($arrFeeDetails['FEE_TYPE'] == 'PENDING') {
			$arrFeeDetails['TOTAL_FEE']		=	$arrFeeDetails['PAID_FEE'] + $asOfNowBalance;
		}*/
		
		$arrFeeDetails['INTERVAL']		=	$row['interval'];
		/*$arrFeeDetails['ACCOUNT']		=	$row['Acc'];
		$arrFeeDetails['INSTALMENT']	=	$row['instalment'];
		$arrFeeDetails['LAST_PAID']		=	$row['Paid_Period'];
		$arrFeeDetails['PRE_BALANCE']	=	$row['Balance_Amount'];*/
		$arrFeeDetails['AS_OF_AMOUNT'] =	$asOfNowBalance;
		$arr1['FEE_DETAILS'][] = $arrFeeDetails;
		$arrT1['TOT_AMOUNT']	+= $row['TOTAL_FEE'];		
	}
		
	$arr =	array_merge($arr, $arrT1);
	$arr =	array_merge($arr, $arr1);
	
}



$sqlFeeHistory	=	"SELECT ADMISSION_ID,CLASS_ID, transId AS FEE_REC_DET_ID,tA.YEAR_ID, tA.FEE_MODE_REF_NO,tA.RECEIPT_ID,tA.RECEIPT_NO, RECEIPT_DATE, Amount AS FEE_AMOUNT, tC.feehead AS FEE_HEAD, tC.feetype AS FEE_TYPE FROM `fee_receipt` tA LEFT JOIN  fee_transanction tB ON tA.RECEIPT_ID = tB.RECEIPT_ID LEFT JOIN feeheads tC ON tB.feeHead = tC.feeheadId WHERE tA.YEAR_ID = '".$yearId."' AND tA.STATUS = '0' AND tA.ADMISSION_ID = '".$arr['ADNO']."' AND tA.CLASS_ID = '".$arr['CLASS_ID']."' ORDER BY tA.RECEIPT_ID DESC ";
$exeFeeHistory	=	mysqli_query($dbconnect,$sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;

if( $cntFeeHistory > 0 ) {
	$arrT2['TOT_HISTORY'] = 0;
	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHistory = array();
		
		$arrFeeHis['FEE_REC_DET_ID']	=	$row['FEE_REC_DET_ID'];
		$arrFeeHis['RECPID']			=	$row['RECEIPT_ID'];
		$arrFeeHis['RECPNO']			=	$row['RECEIPT_NO'];
		if($arrFeeHis['RECPNO'] == ""){
			$arrFeeHis['PAY_ID'] =	$row['RECEIPT_ID'];
			
		}else{
			$arrFeeHis['PAY_ID'] =	$row['RECEIPT_ID'];
		}
		$arrFeeHis['FEE_HEAD']			=	$row['FEE_HEAD'];
		$arrFeeHis['YEAR_ID']			=	$row['YEAR_ID'];
		$arrFeeHis['FEE_TYPE']			=	$row['FEE_TYPE'];
		//$arrFeeHis['PAY_ID']			=	$row['FEE_MODE_REF_NO'];
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
	$totArr =[];
	//$totArr['TOT'] = $arrT1['TOT_AMOUNT']-$arrT2['TOT_HISTORY'];
	$arr	=	array_merge($arr, $arrT2);
	$arr	=	array_merge($arr, $newArr);
	$arr	=	array_merge($arr, $totArr);
}
	
$json_response = json_encode($arr);
echo $json_response;
exit;
	

?>