<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


//$data	=	json_decode(file_get_contents('php://input'), true);


$dateFrom	=	'2017-02-01';	//date("Y-m-d", strtotime($data['dateFrom2']));
$dateTo		=	'2017-02-09';	//date("Y-m-d", strtotime($data['dateTo2']));

//$classId	=	"'21', '22'";
$classId	=	"'22'";
echo "<pre>";


$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_ID, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T6.FeeType AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 JOIN feetype T6 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId AND T4.feeType = T6.FeeTypeId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.CLASS_ID IN(".$classId.") ORDER BY T1.NAME ASC, T3.RECEIPT_ID ASC " ;
echo "SQL : " . $sqlFeeHistory . "<br />";

$exeFeeHistory	=	$mysqli->query($sqlFeeHistory);
$cntFeeHistory	=	$exeFeeHistory->num_rows;


$arr1	=	array();
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
		
		$row['DATE']				=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		
		$arr1[]	=	$row;
	}

}


echo "ORGINAL ARRAY <br />";
print_r($arr1);
echo "ORGINAL ARRAY <br />";


$json_response = json_encode($arr1);

// # Return the response
echo $json_response;
exit;


$arr2	=	[];
$na1	=	array();
$na2	=	array();
foreach($arr1 as $item2) {
	$adno	=	$item2['ADMISSION_ID'];	
	//$newarr[$adno][] = $item;
	$rcptid	=	$item2['RECEIPT_ID'];
	//$arr2[$rcptid][] = $item2;
	$arr2[$adno]	=	array('ADMISSION_ID' => $item2['ADMISSION_ID'], 'NAME' => $item2['NAME'], 'FATHER_NAME' => $item2['FATHER_NAME'], 'GENDER' => $item2['GENDER'],  'STANDARD' => $item2['STANDARD'], 'SECTION' => $item2['SECTION']);
	
	$arr2[$rcptid][]=	array('FEE_HEAD' => $item2['FEE_HEAD'], 'FEE_TYPE' => $item2['FEE_TYPE'], 'FEE_AMOUNT' => $item2['FEE_AMOUNT']);
	
	array_push($arr2[$adno][], $arr2[$rcptid]);
}


echo "<br />---------------------------<br />";
print_r($arr2);
echo "<br />---------------------------<br />";

exit;

$resultArr	=	array();
$jarr = [];
foreach( $arr2 as $key3 => $item3 ) {
	echo $key3 . "<br />";
	
	$arr4	=	[];
	$arr5	=	[];
	$arr4 = array('ADMISSION_ID' => $item3[0]['ADMISSION_ID'], 'NAME' => $item3[0]['NAME'], 'FATHER_NAME' => $item3[0]['FATHER_NAME'], 'GENDER' => $item3[0]['GENDER'],  'STANDARD' => $item3[0]['STANDARD'], 'SECTION' => $item3[0]['SECTION'], 'RECEIPT_ID' => $item3[0]['RECEIPT_ID'], 'DATE' => $item3[0]['DATE']);
	$rid = "";
	foreach( $item3 as $ik3 => $iv3 ) {
		$rid	=	$iv3['RECEIPT_ID'];
		$ad		=	$iv3['ADMISSION_ID'];
		//$arr4 = array('ADMISSION_ID' => $iv3['ADMISSION_ID'], 'NAME' => $iv3['NAME'], 'FATHER_NAME' => $iv3['FATHER_NAME'], 'GENDER' => $iv3['GENDER'],  'STANDARD' => $iv3['STANDARD'], 'SECTION' => $iv3['SECTION'], 'RECEIPT_ID' => $iv3['RECEIPT_ID'], 'DATE' => $iv3['DATE']);
		$arr5['DETAIL'][$rid][] = array('FEE_HEAD' => $iv3['FEE_HEAD'], 'FEE_TYPE' => $iv3['FEE_TYPE'], 'FEE_AMOUNT' => $iv3['FEE_AMOUNT']);
		if( $key3 == $rid ) {
		array_push($jarr, $arr5);
	}
	}
	print_r($arr5);
	
	$arr6 = array_merge($arr4, $arr5);
	array_push($resultArr, $arr6);
}

echo "<hr />#####################<br />";
print_r($jarr);
echo "<hr />#####################<br />";


exit;
$n = [];
foreach($resultArr as $i) {
	print_r($i);
	$n[$i['ADMISSION_ID']]	=	array('ADMISSION_ID' => $i['ADMISSION_ID'], 'NAME' => $i['NAME'], 'FATHER_NAME' => $i['FATHER_NAME'], 'GENDER' => $i['GENDER'],  'STANDARD' => $i['STANDARD'], 'SECTION' => $i['SECTION'], 'RECEIPT_ID' => $i['RECEIPT_ID'], 'DATE' => $i['DATE']);
	$n[$i['ADMISSION_ID']]['DETAIL'][] = $i['DETAIL'];
}
echo "<hr />@@@@@@@@@@@@@@@@@@@@@@@@@<br />";
print_r($n);
echo "<hr />@@@@@@@@@@@@@@@@@@@@@@@@@<br />";








$rarr	=	array();
foreach( $newarr as $key => $val ) {
	$kadno	=	$key;
	
	$amount	= 0;
	foreach($val as $item) {
		$sArr	=	array(
						'ADMISSION_ID' => $item['ADMISSION_ID'],
						'NAME' => $item['NAME'],
						'FATHER_NAME' => $item['FATHER_NAME'],
						'GENDER' => $item['GENDER'],
						'STANDARD' => $item['GENDER'],
						'SECTION' => $item['SECTION']
					);
		$amount	+=	$item['FEE_AMOUNT'];
					
	}
	$sArr['AMOUNT'] = $amount;
	
	array_push($rarr, $sArr);
}




echo "RESULT ARRAY <br />";
print_r($rarr);
echo "RESULT ARRAY <br />";


$json_response = json_encode($rarr);

// # Return the response
echo $json_response;
exit;




?>