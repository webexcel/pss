<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
require('pivot.php');



$data		=	json_decode(file_get_contents('php://input'), true);

$classid	=	implode (",", $data['classId']); 

$query0	=	"SELECT DISTINCT (T3.ADMISSION_ID) FROM fee_receipt T3 WHERE T3.CLASS_ID IN(".$classid.") ";
$exeQuery0	=	$mysqli->query($query0);
$cnt0		=	$exeQuery0->num_rows;

$arr0	=	array();
if( $cnt0 > 0 ) {
	while( $row = $exeQuery0->fetch_assoc() ) {
		$arr0[] = $row;
	}
	$adno	=	"";
	foreach( $arr0 as $item0 ) {
		$adno .= "'".$item0['ADMISSION_ID']."',";
	}
	
	$admission_id = substr($adno ,0, strlen($adno)-1);
}

$query1	=	" SELECT T1.ADMISSION_ID, T1.CLASS_ID, T1.NAME, T1.FATHER_NAME, T1.Gender AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION FROM student_info1 T1 LEFT JOIN tbl_class T2 ON T1.CLASS_ID = T2.CLASS_ID WHERE T1.ADMISSION_ID IN(".$admission_id.") ";

$exeQuery1	=	$mysqli->query($query1);
$cnt1		=	$exeQuery1->num_rows;

$arr1	=	array();
$students	=	array();

if( $cnt1 > 0 ) {
	while( $row = $exeQuery1->fetch_assoc() ) {
		$arr1[]		=	$row;
		$students['STUDENT'][]	=	$row;
	}
		
}
echo json_encode($students);
exit;
$query2		=	"SELECT T3.ADMISSION_ID, T3.RECEIPT_ID FROM fee_receipt T3 WHERE T3.ADMISSION_ID IN(".$admission_id.") ORDER BY T3.RECEIPT_ID DESC ";
$exeQuery2	=	$mysqli->query($query2);
$cnt2		=	$exeQuery2->num_rows;

$arr2	=	array();

if( $cnt2 > 0 ) {
	while( $row = $exeQuery2->fetch_assoc() ) {
		$arr2[] = $row;
	}
	
	$recp	=	"";
	foreach( $arr2 as $item2 ) {
		$recp .= "'".$item2['RECEIPT_ID']."',";
	}
	
	$receipt_id = substr($recp ,0, strlen($recp)-1);
	
	foreach($arr2 as $item2) {	
		$admid	=	$item2['ADMISSION_ID'];
		$repcp	=	$item2['RECEIPT_ID'];
		
		if( $repcp >= 0 && $repcp <= 9  ) {
			$recpid1	=	"#000".$repcp;
		} else if( $repcp >= 10 && $repcp <= 99  ) {
			$recpid1	=	"#00".$repcp;
		} else if( $repcp >= 100 && $repcp <= 999  ) {
			$recpid1	=	"#0".$repcp;
		} else {
			$recpid1	=	"#".$repcp;
		}
		
		$narr1['ADNO'][$admid][] = array('RECEIPT_ID' => $recpid1);

	}
}


$query3	=	"SELECT T3.ADMISSION_ID, T3.RECEIPT_ID, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T6.FeeType AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 JOIN feetype T6 ON T4.feeHead = T5.feeheadId AND T4.feeType = T6.FeeTypeId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.RECEIPT_ID IN(".$receipt_id.") ";
$exeQuery3	=	$mysqli->query($query3);
$cnt3		=	$exeQuery3->num_rows;

$arr3	=	array();

if( $cnt3 > 0 ) {
	while( $row = $exeQuery3->fetch_assoc() ) {
		if( $row['RECEIPT_ID'] >= 0 && $row['RECEIPT_ID'] <= 9  ) {
			$recpid	=	"#000".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] >= 10 && $row['RECEIPT_ID'] <= 99  ) {
			$recpid	=	"#00".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] >= 100 && $row['RECEIPT_ID'] <= 999  ) {
			$recpid	=	"#0".$row['RECEIPT_ID'];
		} else {
			$recpid	=	"#".$row['RECEIPT_ID'];
		}
		$row['RECEIPT_ID']	=	$recpid;
		
		$arr3[] = $row;

	}
	
/*	$narr1 = array();
	
	foreach($arr3 as $item3) {	
		$admid	=	$item3['ADMISSION_ID'];
		$repcp	=	$item3['RECEIPT_ID'];
		
		$narr1[$repcp][$admid][] = array('RECEIPT_ID' => $item3['RECEIPT_ID']);

	}*/
	
	$narr2 = array();
	foreach($arr3 as $item3) {	
		$repcp	=	$item3['RECEIPT_ID'];
		$ad		=	$item3['ADMISSION_ID'];
		//$narr1['ADMISSION_ID'][$repcp][] = array('RECEIPT_ID' => $item3['RECEIPT_ID']);
		$narr2['RECPT'][$ad][$repcp][] = array('RECEIPT_DATE' => $item3['RECEIPT_DATE'], 'FEE_HEAD' => $item3['FEE_HEAD'], 'FEE_TYPE' => $item3['FEE_TYPE'], 'FEE_AMOUNT' => $item3['FEE_AMOUNT']);

	}
}



$new = array_merge($students, $narr2);


echo json_encode($new);


exit;

$res	=	array();
foreach($students['STUDENT'] as $val1) {
	
	$aid =  $val1['ADMISSION_ID'];
	$res1['STUDENT']	=	array (
							'ADMISSION_ID' =>	$val1['ADMISSION_ID'],
							'NAME' =>	$val1['NAME'],
							'FATHER_NAME'  =>	$val1['FATHER_NAME'],
							'GENDER' 	  =>	$val1['GENDER'],
							'CLASS_ID'	  =>	$val1['CLASS_ID'],
							'STANDARD'	  =>	$val1['STANDARD'],
							'SECTION'	  =>	$val1['SECTION']
							);

	//$res1[$aid][] = array();
	foreach($narr1[$aid] as $val2) {
		
		$rid = $val2['RECEIPT_ID'];
		$res1[$aid]['RECEIPT_ID'][] = $rid;
		foreach($narr2[$rid] as $val3) {
			$feeHead	=	$val3['FEE_HEAD'];
			$res1[$rid][$aid][] = array('RECEIPT_DATE' => $val3['RECEIPT_DATE'], 'FEE_HEAD' => $val3['FEE_HEAD'], 'FEE_TYPE' => $val3['FEE_TYPE'], 'FEE_AMOUNT' => $val3['FEE_AMOUNT']);
		}
	}
	
	array_push($res, $res1);
}
//print_r($arr1);
print_r($res);

exit;
echo json_encode($res);


exit;
	
$data = json_decode(file_get_contents('php://input'), true);

/*foreach ($data['classId'] as $key => $value ) {
	echo 'CLASS : '.$value;
	echo "<br />"; 
}
*/

$classid = 21;	//implode (",", $data['classId']); 

$query	=	"SELECT T1.`ADMISSION_ID` AS ADMISSION_NO, T1.`NAME`, T1.`FATHER_NAME`, T1.`Gender` AS GENDER, T2.Standard AS STANDARD, T2.Section AS SECTION, T3.RECEIPT_ID, T3.RECEIPT_DATE, T5.feehead AS FEE_HEAD, T6.FeeType AS FEE_TYPE, T4.Amount AS FEE_AMOUNT FROM `student_info1` T1 JOIN  tbl_class T2 JOIN fee_receipt T3 JOIN fee_transanction T4 JOIN feeheads T5 JOIN feetype T6 ON T1.CLASS_ID = T2.CLASS_ID AND T1.ADMISSION_ID = T3.ADMISSION_ID AND T4.feeHead = T5.feeheadId AND T4.feeType = T6.FeeTypeId WHERE T3.RECEIPT_ID = T4.RECEIPT_ID AND T3.CLASS_ID IN('".$classid."') ";
//echo "SQL : " . $query . "\n";
$exeQuery	=	$mysqli->query($query);
$cnt		=	$exeQuery->num_rows;

$arr	=	array();
if( $cnt > 0 ) {
	$arrdetails	=	array();
	while( $row = $exeQuery->fetch_assoc() ) {
		if( $row['RECEIPT_ID'] >= 0 && $row['RECEIPT_ID'] <= 9  ) {
			$recpid	=	"#000".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] >= 10 && $row['RECEIPT_ID'] <= 99  ) {
			$recpid	=	"#00".$row['RECEIPT_ID'];
		} else if( $row['RECEIPT_ID'] >= 100 && $row['RECEIPT_ID'] <= 999  ) {
			$recpid	=	"#0".$row['RECEIPT_ID'];
		} else {
			$recpid	=	"#".$row['RECEIPT_ID'];
		}
		$row['RECEIPT_ID']	=	$recpid;
		//$arrdetai2['DETAIL']
		
		$arr[] = $row;
		
		$arrdetail1[$recpid][] = array('FEE_HEAD' => $row['FEE_HEAD'], 'FEE_TYPE' => $row['FEE_TYPE'], 'FEE_AMOUNT' => $row['FEE_AMOUNT']);
	}
echo json_encode($arr);
exit;	
	//print_r($arr);
	//print_r($arrdetail1);
	
	foreach($arr as $item) {
		$narr1 = array();
		$repcp	=	$item['RECEIPT_ID'];
		
		$narr2 = array();
		foreach($arrdetail1[$repcp] as $items) {
			$narr2['DETAIL'][] = array('FEE_HEAD' => $items['FEE_HEAD'], 'FEE_TYPE' => $items['FEE_TYPE'], 'FEE_AMOUNT' => $items['FEE_AMOUNT']);
		}
		//print_r($narr1);
		//print_r($narr2);
		$narra3[] = array_merge($narr1, $narr2);
	}
	
	print_r($narra3);
	die('debugging..................!');
	
	
	
	$arrdetail1	=	array();
	$arrdetail2	=	array();
	$i = 0;
	foreach( $arr as $key => $value ) {
		$i++;
		
		$arrdetail1['ADMISSION_NO']	=	$value['ADMISSION_NO'];
		$arrdetail1['NAME']			=	$value['NAME'];
		$arrdetail1['FATHER_NAME']	=	$value['FATHER_NAME'];
		$arrdetail1['GENDER']		=	$value['GENDER'];
		$arrdetail1['STANDARD']		=	$value['STANDARD'];
		$arrdetail1['SECTION']		=	$value['SECTION'];
		$arrdetail1['RECEIPT_ID']	=	$value['RECEIPT_ID'];
		$arrdetail1['RECEIPT_DATE']	=	$value['RECEIPT_DATE'];
		
		$receiptid	=	$value['RECEIPT_ID'];

				
		
		
		if(array_key_exists($receiptid, $arrdetail1)) {
			echo $receiptid. " Key exists";
			echo " \n";
			$arrdetail1['ADMISSION_NO']	=	$value['ADMISSION_NO'];
			$arrdetail1['NAME']			=	$value['NAME'];
			$arrdetail1['FATHER_NAME']	=	$value['FATHER_NAME'];
			$arrdetail1['GENDER']		=	$value['GENDER'];
			$arrdetail1['STANDARD']		=	$value['STANDARD'];
			$arrdetail1['SECTION']		=	$value['SECTION'];
			$arrdetail1['RECEIPT_ID']	=	$value['RECEIPT_ID'];
			$arrdetail1['RECEIPT_DATE']	=	$value['RECEIPT_DATE'];
			$arrdetail1[$receiptid][] = array('FEE_HEAD' => $value['FEE_HEAD'], 'FEE_TYPE' => $value['FEE_TYPE'], 'FEE_AMOUNT' => $value['FEE_AMOUNT']);
		} else {
			echo $receiptid." Key Not exists";
			echo " \n";
			
			$arrdetail1['ADMISSION_NO']	=	$value['ADMISSION_NO'];
			$arrdetail1['NAME']			=	$value['NAME'];
			$arrdetail1['FATHER_NAME']	=	$value['FATHER_NAME'];
			$arrdetail1['GENDER']		=	$value['GENDER'];
			$arrdetail1['STANDARD']		=	$value['STANDARD'];
			$arrdetail1['SECTION']		=	$value['SECTION'];
			$arrdetail1['RECEIPT_ID']	=	$value['RECEIPT_ID'];
			$arrdetail1['RECEIPT_DATE']	=	$value['RECEIPT_DATE'];
			
			$arrdetail1[$receiptid][0] = array('FEE_HEAD' => $value['FEE_HEAD'], 'FEE_TYPE' => $value['FEE_TYPE'], 'FEE_AMOUNT' => $value['FEE_AMOUNT']);
			
		}

		//$arrdetails[] = $arrdetail1;
		
		
		
	}
	


echo "<pre>";
echo "<br />--------ORGINAL-------<br />";
print_r($arr);
echo "<br />-------MODIFIED--------<br />";

$data = Pivot::factory($arr)
    ->pivotOn(array('RECEIPT_ID', 'RECEIPT_DATE'))
    ->addColumn(array('FEE_HEAD'), array('FEE_TYPE'), array('FEE_AMOUNT'))
    ->fetch();

print_r($data);
echo "<br />-------END--------<br />";
die('debugging.............!');


print_r($arrdetail1);
	
} else {
	$arr['status'] = 'No records found.';
	
}



die('debugging.............!');
echo "<pre>";
//print_r($arrdetails);
echo "<br />------------PARASURAMAN M---------------<br />";
//print_r($arrdetail);

echo "<br />------------PARASURAMAN M---------------<br />";

echo json_encode($arr);





?>
	