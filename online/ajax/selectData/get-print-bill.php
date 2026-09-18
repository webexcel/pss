<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');


$_POST	=	json_decode(file_get_contents('php://input'), true);




if( isset($_GET['mode']) && $_GET['mode'] == 'bill' ) {
	
	$adno	=	$_POST['sDetail']['ADMISSION_ID'];
	$name	=	$_POST['sDetail']['NAME'];
	$fatherName	=	$_POST['sDetail']['FATHER_NAME'];
	$classId	=	$_POST['sDetail']['CLASS_ID'];
	$std		=	$_POST['sDetail']['STD'];
	$sec		=	$_POST['sDetail']['SEC'];
	
	$sqlFeeDetails	=	"SELECT fee.CLASS_ID, fee.feeheadId, fee.FeeHead, fee.FeeType,
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
		while( $row = $exeFeeDetails->fetch_assoc() ) {
			
			$arrFeeDetails = array();
			$classId	= $row['CLASS_ID'];
			$arrFeeDetails['FEE_HEAD_ID']	= $row['feeheadId'];
			$arrFeeDetails['TOTAL_FEE'] 	= $row['TOTAL_FEE'];
			
			$feeDetails[] = $arrFeeDetails;
		}
	}
	$curDate	=	date("Y-m-d");
	$feeMode	=	'';
	$feeRemarks	=	'';
	$yearId		=	$_SESSION['YEAR_ID'];
	
	$insFeeReceipt	=	"INSERT INTO `fee_receipt` (`ADMISSION_ID`, `CLASS_ID`, `RECEIPT_DATE`, `FEE_MODE`, `FEE_REMARKS`, `YEAR_ID`) VALUES ('".$adno."', '".$classId."', '".$curDate."', '".$feeMode."', '".$feeRemarks."', '".$yearId."') ";
	
	if ($mysqli->query($insFeeReceipt) === TRUE) {
		$last_id = $mysqli->insert_id;
		foreach($feeDetails as $key => $val) {
			$insFeeTransaction	=	"INSERT INTO `fee_transanction` (`RECEIPT_ID`, `feeHead`, `Amount`) VALUES ('".$last_id."', '".$val['FEE_HEAD_ID']."', '".$val['TOTAL_FEE']."') ";
			$mysqli->query($insFeeTransaction);
		}
	}
	
	//require_once("../../form/printFiles/generatePdf.php");
	
	//$arr['SRC']	=	$dirPdfPath	;
	$json_response = json_encode($arr);
	echo $json_response;
	
	exit;
}

if( isset($_POST['section']) ) {
	$section	=	trim($_POST['section']);
} else {
	$section	=	"";
}

$yearId	=	$_SESSION['YEAR_ID'];
if( $section == "" ) {
	$query	=	" SELECT T2.`CLASS_ID`, T2.Standard AS STD, T2.Section AS SEC, T1.`NAME`, T1.`FATHER_NAME`, T1.`ADMISSION_ID` FROM student_info1 T1 LEFT JOIN tbl_class T2 ON T1.CLASS_ID = T2.CLASS_ID WHERE T1.ADMISSION_ID IN (SELECT DISTINCT(ADMISSION_ID) FROM `fee_receipt` WHERE STATUS = 0 AND YEAR_ID = '".$yearId."') ORDER BY T1.CLASS_ID, T1.NAME ";
} else {
	$query	=	" SELECT T2.`CLASS_ID`, T2.Standard AS STD, T2.Section AS SEC, T1.`NAME`, T1.`FATHER_NAME`, T1.`ADMISSION_ID` FROM student_info1 T1 LEFT JOIN tbl_class T2 ON T1.CLASS_ID = T2.CLASS_ID WHERE T1.ADMISSION_ID IN (SELECT DISTINCT(ADMISSION_ID) FROM `fee_receipt` WHERE STATUS = 0 AND YEAR_ID = '".$yearId."') AND T2.CLASS_ID = '".$section."' ORDER BY T1.CLASS_ID, T1.NAME ";
}


//echo $query;
$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		
		$sno++;
		
		$row['sno']	=	$sno;
		$std	=	$row['STD'];
		$sec	=	($row['SEC']) ? '-'.$row['SEC'] : '';
		$std_sec=	$std . $sec;
		$row['STD_SEC'] =	$std_sec;
		
		$classId			=	$row['CLASS_ID'];
		$sqlFeeTotal		=	" SELECT COALESCE(SUM(feeAmount), 0) AS TOT_AMOUNT FROM `feegroupmapping` WHERE FeeGrpID = (SELECT feeGrpId FROM `tbl_class` WHERE CLASS_ID = '".$classId."' ) ";
		$exeSqlFeeTotal		=	$mysqli->query($sqlFeeTotal);
		$resExeSqlFeeTotal 	=	$exeSqlFeeTotal->fetch_assoc();
		$row['TOT_AMOUNT']	=	$resExeSqlFeeTotal['TOT_AMOUNT'];
		
		$admId				=	$row['ADMISSION_ID'];
		$sqlFeePaid			=	" SELECT COALESCE(SUM(Amount), 0) AS TOT_PAID FROM `fee_transanction` WHERE RECEIPT_ID IN(SELECT RECEIPT_ID FROM `fee_receipt` WHERE ADMISSION_ID = '".$admId."' AND STATUS = 0 AND YEAR_ID = '".$yearId."') ";
		$exeSqlFeePaid		=	$mysqli->query($sqlFeePaid);
		$resExeSqlFeePaid	=	$exeSqlFeePaid->fetch_assoc();
		$row['TOT_PAID']	=	$resExeSqlFeePaid['TOT_PAID'];
		
		
		/*
		$query3				=	"SELECT T3.ADMISSION_ID, T3.RECEIPT_ID, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T6.FeeType AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 JOIN feetype T6 ON T4.feeHead = T5.feeheadId AND T4.feeType = T6.FeeTypeId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_ID IN(SELECT RECEIPT_ID FROM `fee_receipt` WHERE ADMISSION_ID = '".$admId."') AND T3.YEAR_ID = '".$yearId."' ORDER BY T4.RECEIPT_ID ASC ";
		$exeQuery3			=	$mysqli->query($query3);
		$cnt3				=	$exeQuery3->num_rows;
		
		$row['DETAILS']	=	array();
		if( $cnt3 > 0 ) {
			$arr3	=	array();
			while( $row1 = $exeQuery3->fetch_assoc() ) {
				if( $row1['RECEIPT_ID'] >= 0 && $row1['RECEIPT_ID'] <= 9  ) {
					$recpid	=	"#000".$row1['RECEIPT_ID'];
				} else if( $row1['RECEIPT_ID'] >= 10 && $row1['RECEIPT_ID'] <= 99  ) {
					$recpid	=	"#00".$row1['RECEIPT_ID'];
				} else if( $row1['RECEIPT_ID'] >= 100 && $row1['RECEIPT_ID'] <= 999  ) {
					$recpid	=	"#0".$row1['RECEIPT_ID'];
				} else {
					$recpid	=	"#".$row1['RECEIPT_ID'];
				}
				$row1['RECEIPT_ID']	=	$recpid;
				
				$arr3[] = $row1;
		
			}
			
			$nArr = array();
			foreach($arr3 as $item3) {	
				
				
				$repcp	=	$item3['RECEIPT_ID'];
				$ad		=	$item3['ADMISSION_ID'];
				//$row['DETAILS'][$ad][$repcp][] = array('RECEIPT_DATE' => $item3['RECEIPT_DATE'], 'FEE_HEAD' => $item3['FEE_HEAD'], 'FEE_TYPE' => $item3['FEE_TYPE'], 'FEE_AMOUNT' => $item3['FEE_AMOUNT']);
				
				$row['DETAILS'][$ad][$repcp][] = array('RECEIPT_DATE' => $item3['RECEIPT_DATE'], 'FEE_HEAD' => $item3['FEE_HEAD'], 'FEE_TYPE' => $item3['FEE_TYPE'], 'FEE_AMOUNT' => $item3['FEE_AMOUNT']);				
			}

		}
		*/
		
		
		$arr[]		=	$row;
	}
}

/*
$parr	=	array();
$pnarr	=	array();
foreach( $arr as $pitem ) {
	
	$padno	=	$pitem['ADMISSION_ID'];
	$parr	=	array('U_PDF' => $_SESSION['SESS_MEMBER_DBNAME'], 'ADMISSION_ID' => $pitem['ADMISSION_ID'], 'NAME' => $pitem['NAME'], 'FATHER_NAME' => $pitem['FATHER_NAME'], 'STD' => $pitem['STD'], 'SEC' => $pitem['SEC'],  'STD_SEC' => $pitem['STD_SEC'], 'TOT_AMOUNT' => $pitem['TOT_AMOUNT'], 'TOT_PAID' => $pitem['TOT_PAID'] );
	
	//print_r($pitem['DETAILS'][$padno]);
	//$parr['DETAILS'][] = $pitem['DETAILS'][$padno];
	
	$parr['DETAILS'][] = $pitem['DETAILS'][$padno];
	array_merge($parr, $parr['DETAILS']);
	
	$pnarr[] = $parr;

}

*/

# JSON-encode the response
$json_response = json_encode($arr);
//$json_response = json_encode($pnarr);

// # Return the response
echo $json_response;


exit;





?>
	