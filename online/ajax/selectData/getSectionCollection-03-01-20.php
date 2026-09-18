<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$yearId	=	$_SESSION['YEAR_ID'];
$arr	=	[];

//$sql1	=	" SELECT T1.CLASS_ID, T2.Standard AS STANDARD, T2.Section AS SECTION, T2.feeGrpId AS GROUP_ID, COUNT(T1.CLASS_ID) AS TOT_STUDENT FROM `student_info1` T1, tbl_class T2 WHERE T1.CLASS_ID = T2.CLASS_ID GROUP BY T1.CLASS_ID ";
//$sql1	=	" SELECT CLASS_ID,`GroupId` as GROUP_ID,`Grp_Name` as GROUP_NAME,Standard AS STANDARD,Section AS SECTION,count(`ADMISSION_ID`) as TOT_STUDENT FROM `v_studentlist` WHERE `Year_Id` = '".$yearId."' group by `GroupId`";
$sql1	=	" SELECT `class_id` as CLASS_ID, `Grp_Id` as GROUP_ID,`CLASSSEC` as CLASSSEC, `Standard` as STANDARD, `Section` as SECTION, COUNT(class_id) AS TOT_STUDENT FROM `v_dashboard` WHERE Year_Id = '".$yearId."' GROUP BY CLASSSEC order by class_id ";
$exe1	=	$mysqli->query($sql1);

$subpaid = 0;
$subbalance = 0;
$subamount = 0;

while( $row1 = $exe1->fetch_assoc() ) {
	$sql2	=	"SELECT SUM(feeAmount) AS TOT_AMOUNT FROM `feegroupmapping` WHERE FeeGrpID = '".$row1['GROUP_ID']."' AND FeeHeadId != '0' AND Year_Id = '".$yearId."'";
	//$sql2	=	"SELECT SUM(feeAmount) AS TOT_AMOUNT FROM `feegroupmapping` WHERE FeeGrpID = '".$row1['GROUP_ID']."' AND FeeHeadId != '0'";
	$exe2	=	$mysqli->query($sql2);
	$row2	=	$exe2->fetch_assoc();
	
	$sql3	=	"SELECT SUM(T2.Amount) AS SEC_PAID FROM `fee_receipt` T1, `fee_transanction` T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.CLASS_ID = '".$row1['CLASS_ID']."' AND T1.STATUS = 0 AND T1.YEAR_ID = '".$yearId."'  ";
	//$sql3	=	"SELECT SUM(T2.Amount) AS SEC_PAID FROM `fee_receipt` T1, `fee_transanction` T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.CLASS_ID = '".$row1['CLASS_ID']."' AND T1.STATUS = 0 ";
	$exe3	=	$mysqli->query($sql3);
	$row3	=	$exe3->fetch_assoc();
	
	//$sql4	=	"SELECT  `CLASS_ID` , COUNT( DISTINCT  `ADMISSION_ID` ) as CNT FROM  `fee_receipt` where status = 0 AND CLASS_ID = '".$row1['CLASS_ID']."' AND YEAR_ID = '".$yearId."' GROUP BY  `CLASS_ID`  ";
	//$sql4	=	"SELECT  `CLASS_ID` , COUNT( DISTINCT  `ADMISSION_ID` ) as CNT FROM  `fee_receipt` where status = 0 AND CLASS_ID = '".$row1['CLASS_ID']."' AND YEAR_ID = '".$yearId."' GROUP BY  `CLASS_ID`  ";
	//$sql4	=	"SELECT  `CLASS_ID` , COUNT( DISTINCT  `ADMISSION_ID` ) as CNT FROM  `fee_receipt` where status = 0 AND CLASS_ID = '".$row1['CLASS_ID']."' GROUP BY  `CLASS_ID`  ";
	//$exe4	=	$mysqli->query($sql4);
	//$row4	=	$exe4->fetch_assoc();	
	
	$tmp	=	array();
	//$sec	=	($row1['SECTION']) ? "-".$row1['SECTION'] : '';
	
	//$tmp['STD_SEC']      = $row1['STANDARD'].$sec;
	
	$tmp['STD_SEC']      = $row1['CLASSSEC'];
	$tmp['TOT_STUDENT']  = $row1['TOT_STUDENT'];
	//$tmp['PAID_STUDENT'] = $row4['CNT'];
	$tmp['TOT_AMOUNT']   = $row2['TOT_AMOUNT'];
	$tmp['TOT_VALUE']    = $row1['TOT_STUDENT'] * $row2['TOT_AMOUNT'];
	$tmp['SEC_PAID']     = $row3['SEC_PAID'];
	$tmp['BALANCE']      = $tmp['TOT_VALUE'] - $row3['SEC_PAID'];	
	//$tmp['NON_PAID']	 = $tmp['TOT_STUDENT'] - $tmp['PAID_STUDENT'];
	$subpaid	+= $tmp['SEC_PAID'];
	$subbalance += $tmp['BALANCE'];
	$subamount  += $tmp['TOT_VALUE'];
	$arr[] = $tmp;
	
}

$narr = array_merge(array('result'=>$arr), array('SUB_TOTAL' => $subamount, 'SUB_BAL_TOTAL' => $subbalance, 'SUB_PAID_TOTAL' => $subpaid));

$json_response = json_encode($narr);

// # Return the response
echo $json_response;
exit;



?>