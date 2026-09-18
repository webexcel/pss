<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);

$adno = $_POST['adno'];
//"SELECT * FROM `v_studentlist` a  JOIN v_fees b ON a.CLASS_ID = b.feeclassid JOIN feesreceipt c ON  c.ADMISSION_ID = a.ADMISSION_ID  WHERE a.`ADMISSION_ID` = '18251'";
//$query	=	" SELECT * FROM `v_studentlist` a LEFT JOIN v_fees b ON a.CLASS_ID = b.feeclassid  WHERE a.`ADMISSION_ID` = '".$adno."' ";

//$query	=	" SELECT `StId`, `ADMISSION_ID`, `CLASS_ID`, `CLASSSEC`, `NAME`, `FATHER_NAME`, `DOB`, `rollNumber`, `grp`, `Gender`, `IILanguage`, `Type`, `Boarder`, `Religion`, `Nationality`, `Caste`, `Community`, `MotherTongue`, `BloodGroup`, `HouseName`, `photo`, `Department`, `stuStatus` FROM `student_info1` WHERE `ADMISSION_ID` = '".$adno."' ";
$query	=	" SELECT `CLASS_ID`, CONCAT(`Standard`, '-', `Section`) AS CLASS_SECTION, `NAME`, `FATHER_NAME`, `ADMISSION_ID` FROM `v_studentlist` WHERE `ADMISSION_ID` = '".$adno."' ";
//echo "SQL : " . $query . "<br />";
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
		
	}
}

/*
$sqlFeeDetails	=	"SELECT tran.ADMISSION_ID, fee.CLASS_ID, fee.feeheadId, fee.FeeHead, fee.feetypeid, fee.FeeType,
	IFNULL(tran.TOT_AMOUNT,0) as PAID_FEE,
    IFNULL(fee.feeamount,0) as TOTAL_FEE, (fee.feeamount -  IFNULL( TOT_AMOUNT , 0)) as REMAINING_FEE
	FROM v_fees fee   LEFT OUTER JOIN v_feestrans tran
	ON fee.feeHeadId = tran.feeHeadId  AND fee.Class_Id = tran.Class_Id 
	AND tran.Admission_Id =  '".$arr['ADNO']."'    
	WHERE Fee.Class_ID  IN (SELECT Class_ID FROM student_info1 WHERE Admission_Id =  '".$arr['ADNO']."'    ) ";
*/
$sqlFeeDetails	=	"SELECT fee.CLASS_ID, fee.feeheadId, fee.FeeHead, fee.feetypeid, fee.FeeType,
IFNULL(tran.TOT_AMOUNT,0) as PAID_FEE,
IFNULL(fee.feeamount,0) as TOTAL_FEE, (fee.feeamount -  IFNULL( TOT_AMOUNT , 0)) as REMAINING_FEE
FROM v_fees fee   LEFT OUTER JOIN v_feestrans tran
ON fee.feeHeadId = tran.feeHeadId  AND fee.CLASS_ID = tran.CLASS_ID 
AND tran.Admission_Id =  '".$arr['ADNO']."'
WHERE Fee.Class_ID  IN (SELECT Class_ID FROM student_info1 WHERE Admission_Id =  '".$arr['ADNO']."' ) ";

//echo "SQL : " . $sqlFeeDetails . "<br />";

//$sqlFeeDetails	=	" SELECT * FROM `v_fees` WHERE `CLASS_ID` = '".$arr['CLASSID']."' ";
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
		
		$arr1['FEE_DETAILS'][] = $arrFeeDetails;
		$arrT1['TOT_AMOUNT']	+= $row['TOTAL_FEE'];
	}

	$arr =	array_merge($arr, $arrT1);
	$arr =	array_merge($arr, $arr1);
}


$sqlFeeConcession	=	"SELECT SUM(`CONCESSION_AMOUNT`) AS CONCESSION_AMOUNT FROM `fee_concession` WHERE `ADMISSION_ID` = '".$arr['ADNO']."' ";
$exeFeeConcession	=	$mysqli->query($sqlFeeConcession);
$resFeeConcession	=	$exeFeeConcession->fetch_assoc();
$arr5['CONCESSION_AMOUNT'] = $resFeeConcession['CONCESSION_AMOUNT'];

$arr =	array_merge($arr, $arr5);


$sqlFeeHistory	=	"SELECT * FROM `feesreceipt` A LEFT JOIN feeheads B ON A.fee_head = B.feeheadId JOIN feetype C ON A.fee_type = c.FeeTypeId WHERE A.ADMISSION_ID = '".$arr['ADNO']."' AND A.CLASS_ID = '".$arr['CLASS_ID']."' ORDER BY A.rec_date DESC ";
//echo "SQL : " . $sqlFeeHistory . "<br />";
$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;



if( $cntFeeHistory > 0 ) {
	while( $row = $exeFeeHistory->fetch_assoc() ) {
		$arrFeeHistory = array();
		
		$arr['TOT_AMOUNT'][$row['fee_head']] = $row['TOT_AMOUNT'];
		$arrFeeHis['RECPID']	=	$row['ReceiptID'];
		$arrFeeHis['FEE_HEAD'] = $row['feehead'];
		$arrFeeHis['FEE_TYPE'] = $row['FeeType'];
		$arrFeeHis['DATE'] 	= date("d-M-Y", strtotime($row['rec_date']));
		$arrFeeHis['PAID_AMOUNT'] = $row['Amount'];
		
		//$arr2['FEE_HISTORY'][] = $arrFeeHis;
		$arr2[] = $arrFeeHis;
		$arrT2['TOT_HISTORY'] += $row['Amount'];
	}
	

	$newArr	=	[];
	foreach( $arr2 as $key => $value ) {
		$date	=	$value['DATE'];
		$newArr['FEE_HISTORY'][$date][] = $value;
	}


	$arr	=	array_merge($arr, $arrT2);
	$arr	=	array_merge($arr, $newArr);
}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;
	

	

?>