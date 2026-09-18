<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
require_once('../function.php');
session_start();
$data	=	json_decode(file_get_contents('php://input'), true);

$yearId	=	$_SESSION['YEAR_ID'];

/*
if(!empty($data)) {
	$section	=	($data['section']) ? $data['section'] : "";
	$fmonth		=	($data['FMonth']) ? $data['FMonth'] : "";
	$tmonth		=	($data['TMonth']) ? $data['TMonth'] : "";
	if($section != "" && $fmonth == "" && $tmonth == "") {
		$classId	=	$section;
		$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		AND T2.CLASS_ID = '".$classId."'
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";
	
	} else if($section != "" && $fmonth != "" && $tmonth == "") {
		$classId	=	$section;
		$month		=	$fmonth;
		$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		AND T2.CLASS_ID = '".$classId."'
		AND T3.Paid_Period = '".$month."'		

		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";	
	} else if($section != "" && $fmonth != "" && $tmonth != "") {
		$classId	=	$section;
		$fm	=	month2Number($fmonth);
		$tm	=	month2Number($tmonth);
		for( $i = $fm; $i <= $tm; $i++ ) {
			$j .= "'". number2Month($i) . "', " ;
		}

		$month = substr(trim($j), 0, -1);

		$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		AND T2.CLASS_ID = '".$classId."'
		AND T3.Paid_Period IN(".$month.")
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";
		
	} else if($section == "" && $fmonth != "" && $tmonth != "") {
		
		$fm	=	month2Number($fmonth);
		$tm	=	month2Number($tmonth);
		for( $i = $fm; $i <= $tm; $i++ ) {
			$j .= "'". number2Month($i) . "', " ;
		}

		$month = substr(trim($j), 0, -1);

		$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		AND T3.Paid_Period IN(".$month.")
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";
	} else if($section == "" && $fmonth != "" && $tmonth == "") {
		
		$month = $fmonth;

		$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		AND T3.Paid_Period = '".$month."'
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";
	} else {
		$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";	
	}
	
} else {
	//$query	=	" SELECT T2.`CLASS_ID`, T2.Standard AS STD, T2.Section AS SEC, T1.`NAME`, T1.`FATHER_NAME`, T1.`ADMISSION_ID`, T3.Paid_Period AS LAST_PAID, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T3.Balance_Amount AS BALANCE FROM student_info1 T1 LEFT JOIN tbl_class T2 ON T1.CLASS_ID = T2.CLASS_ID LEFT JOIN feestatus T3 ON T1.ADMISSION_ID = T3.Admission_Id LEFT JOIN feeheads T4 ON T3.Fee_Headid = T4.feeheadId WHERE YEAR_ID = '".$yearId."' ORDER BY T1.CLASS_ID, T1.NAME, T3.Fee_Headid ASC ";
	$query	=	" 
	SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
	FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
	WHERE T1.ADMISSION_ID = T3.Admission_Id
	AND T4.CLASS_ID = T1.CLASS_ID
	AND T4.feeHeadId = T3.fee_headId
	AND T2.CLASS_ID = T1.CLASS_ID
	
	AND T1.ADMISSION_ID IN(1,2,3,4,1055,3483)
	
	ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";

}
*/

if(!empty($data)) {
	$section	=	($data['section']) ? $data['section'] : "";
	//$fmonth		=	($data['FMonth']) ? $data['FMonth'] : "";
	//$tmonth		=	($data['TMonth']) ? $data['TMonth'] : "";
	
	
	if($section != "" ) {
		$classId	=	$section;
		
		$where	=	" AND T1.CLASS_ID = '".$classId."' ";
		$group = ",T1.CLASS_ID";
	}
	
	$query = "SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T1.Standard AS STD, T1.Section AS SEC, T3.Paid_Period AS LAST_PAID, sum(T3.Balance_Amount) AS TOT_BAL, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT,sum(T4.feeamount) as TOT_AMT
		FROM v_studentlist T1, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T1.CLASS_ID = T1.CLASS_ID ".$where."
		AND T1.Year_Id = '".$yearId."'
		group by T1.ADMISSION_ID
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC";
	/*
	$query	=	" 
	SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
	FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
	WHERE T1.ADMISSION_ID = T3.Admission_Id
	AND T4.CLASS_ID = T1.CLASS_ID
	AND T4.feeHeadId = T3.fee_headId
	AND T2.CLASS_ID = T1.CLASS_ID
	".$where."
	
	ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";
	*/
} 
else {
		$query = "SELECT T1.ADMISSION_ID, 
		T1.NAME, T1.FATHER_NAME, 
		T1.Standard AS STD, 
		T1.Section AS SEC, 
		sum(T3.Balance_Amount) AS TOT_BAL, 
		sum(T4.feeamount) as TOT_AMT
		FROM 
		v_studentlist T1,
		student_class_map T2, 
		feestatus T3, 
		v_fees T4
		WHERE 
		T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T2.feeGrpId = T4.GroupId
	    AND T1.Year_Id = '".$yearId."'	
		group by T1.ADMISSION_ID
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC";
		
		/*$query	=	" 
		SELECT T3.FSID,  T1.ADMISSION_ID, T1.NAME, T1.FATHER_NAME, T2.Standard AS STD, T2.Section AS SEC, T3.Paid_Period AS LAST_PAID, T3.Balance_Amount AS BALANCE, T4.feehead AS FEE_HEAD, T4.feetype AS FEE_TYPE, T4.interval AS FEE_INTERVAL, T4.instalment AS FEE_INSTALMENT
		FROM student_info1 T1, tbl_class T2, feestatus T3, v_fees T4
		WHERE T1.ADMISSION_ID = T3.Admission_Id
		AND T4.CLASS_ID = T1.CLASS_ID
		AND T4.feeHeadId = T3.fee_headId
		AND T2.CLASS_ID = T1.CLASS_ID
		
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID, T3.FSID ASC ";*/
}

//echo $query . "\n";
$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	$totamt=0;
	$totpaid =0;
	$totbal=0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		
		$paid_amount = "SELECT COALESCE(sum(fee_transanction.Amount),0) as TOT_PAID FROM `fee_receipt` join fee_transanction on (`fee_receipt`.`RECEIPT_ID` = fee_transanction.`RECEIPT_ID`) where fee_receipt.`ADMISSION_ID` ='".$row['ADMISSION_ID']."' and fee_receipt.`YEAR_ID` ='".$yearId."' and fee_receipt.status = '0'";
		$result1	=	$mysqli->query($paid_amount);
		$row1 = $result1->fetch_assoc();
		
		$narr = array();
		
		$std	=	$row['STD'];
		$sec	=	($row['SEC']) ? '-'.$row['SEC'] : '';
		$std_sec=	$std . $sec;
		$narr['SNO']		=	$sno;
		$narr['ADNO']		=	$row['ADMISSION_ID'];
		$narr['NAME']		=	$row['NAME'];
		$narr['FATHER_NAME']=	$row['FATHER_NAME'];
		$narr['STD_SEC']	=	$std_sec;
		$narr['TOT_AMT']	=	$row['TOT_AMT'];			
		$narr['TOT_PAID']	=	$row1['TOT_PAID'];
		$narr['TOT_BAL']	=	$narr['TOT_AMT'] - $narr['TOT_PAID'];

		$totamt += $row['TOT_AMT'];
		$totpaid += $row1['TOT_PAID'];
		$totbal = $totamt - $totpaid;
		
		$arr[] = $narr;
	}
}
$final = array_merge(array('result'=> $arr),array('totamt'=> $totamt,'totpaid'=>$totpaid,'totbal'=>$totbal));

$json_response = json_encode($final);

echo $json_response;


exit;
/*
foreach($arr as $key => $value) {
    if (!empty($value['ADNO'])) {
        $adNumArray[] = $value['ADNO'];
    }
}
/*
//echo "<pre>";
//print_r($adNumArray);
$adNum = array_unique($adNumArray);
//print_r($adNum);
$result = array();
$result1 = array();
foreach ($adNum as $key1 => $value1) {
    $i = 0;
	$j = 0;
    foreach ($arr as $key2 => $value2) {
        
		if ($value1 == $value2['ADNO']) {
            $bal	=	0;
			$result[$value1]['SNO'] = $value2['SNO'];
            $result[$value1]['ADNO'] = $value2['ADNO'];
            $result[$value1]['NAME'] = $value2['NAME'];
            $result[$value1]['FATHER_NAME'] = $value2['FATHER_NAME'];
            $result[$value1]['STD_SEC'] = $value2['STD_SEC'];
			$j	+=	$value2['BALANCE'];
			$result[$value1]['TOT_BAL'] = $j;
			$result[$value1]['TOT_PAID'] = $value2['TOT_PAID'];
			$result[$value1]['TOT_AMT'] = $result[$value1]['TOT_PAID']+$result[$value1]['TOT_BAL'];
            
			
			$result[$value1]['DETAILS'][$i]['FEE_HEAD'] = $value2['FEE_HEAD'];
            $result[$value1]['DETAILS'][$i]['FEE_TYPE'] = $value2['FEE_TYPE'];
            $result[$value1]['DETAILS'][$i]['FEE_INTERVAL'] = $value2['FEE_INTERVAL'];
            $result[$value1]['DETAILS'][$i]['FEE_INSTALMENT'] = $value2['FEE_INSTALMENT'];
            $result[$value1]['DETAILS'][$i]['LAST_PAID'] = $value2['LAST_PAID'];
            $result[$value1]['DETAILS'][$i]['BALANCE'] = $value2['BALANCE'];
			
			//$totpaid += $result[$value1]['DETAILS'][$i]['LAST_PAID'];
			$totbal +=  $result[$value1]['DETAILS'][$i]['BALANCE'];
			
        $i++;
        }
    }
}

$result = array_values($result);*/
//exit;



?>
	