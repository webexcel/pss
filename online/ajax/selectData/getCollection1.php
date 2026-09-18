<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

$arr	=	[];

$sql1	=	" SELECT T2.Standard AS STANDARD, T2.Section AS SECTION, T2.feeGrpId AS GROUP_ID, COUNT(T1.CLASS_ID) AS TOT_STUDENT FROM `student_info1` T1, tbl_class T2 WHERE T1.CLASS_ID = T2.CLASS_ID GROUP BY T1.CLASS_ID ";
$exe1	=	$mysqli->query($sql1);

$subamount = 0;
while( $row1 = $exe1->fetch_assoc() ) {
	$sql2	=	" SELECT SUM(feeAmount) AS TOT_AMOUNT FROM `feegroupmapping` WHERE FeeGrpID = '".$row1['GROUP_ID']."' ";
	$exe2	=	$mysqli->query($sql2);
	$row2	=	$exe2->fetch_assoc();
	
	$tmp	=	array();
	
	$sec	=	($row1['SECTION']) ? "-".$row1['SECTION'] : '';
	
	$tmp['STD_SEC'] = $row1['STANDARD'] . $sec;
	$tmp['TOT_STUDENT'] = $row1['TOT_STUDENT'];
	$tmp['TOT_AMOUNT'] = $row2['TOT_AMOUNT'];
	$tmp['TOT_VALUE'] = $row1['TOT_STUDENT'] * $row2['TOT_AMOUNT'];
	$subamount += $tmp['TOT_VALUE'];
	$arr[] = $tmp;
	
}

$narr = array_merge($arr, array('SUB_TOTAL' => $subamount));


echo "<pre>";
print_r($narr);

$json_response = json_encode($arr);

// # Return the response
echo $json_response;
exit;



?>