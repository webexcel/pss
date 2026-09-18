<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


//$data	=	json_decode(file_get_contents('php://input'), true);


$dateFrom	=	'2017-02-01';	//date("Y-m-d", strtotime($data['dateFrom2']));
$dateTo		=	'2017-02-09';	//date("Y-m-d", strtotime($data['dateTo2']));


$sqlFeeHistory	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_ID, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T6.FeeType AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 JOIN feetype T6 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId AND T4.feeType = T6.FeeTypeId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_DATE BETWEEN '".$dateFrom."' AND '".$dateTo."' ORDER BY T1.NAME ASC, T3.RECEIPT_ID ASC " ;
//echo "SQL : " . $sqlFeeHistory . "<br />";
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
		
		$row['DATE']				=	date("d-M-Y", strtotime($row['RECEIPT_DATE']));
		
		$arr[]	=	$row;
	}

}
//$json_response = json_encode($arr);

// # Return the response
//echo $json_response;
//exit;


$newarr	=	[];
foreach($arr as $item) {
	//$adno	=	$item['ADMISSION_ID'];	
	//$newarr[$adno][] = $item;
	
	$adno	=	$item['ADMISSION_ID'];
	$newarr[$adno][] = $item;
	
}


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





print_r($rarr);


$json_response = json_encode($rarr);

// # Return the response
echo $json_response;
exit;




?>