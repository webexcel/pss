<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$yearId	=	$_SESSION['YEAR_ID'];
$arr	=	[];

//$sql1	=	" SELECT T1.CLASS_ID, T2.Standard AS STANDARD, T2.Section AS SECTION, T2.feeGrpId AS GROUP_ID, COUNT(T1.CLASS_ID) AS TOT_STUDENT FROM `student_info1` T1, tbl_class T2 WHERE T1.CLASS_ID = T2.CLASS_ID GROUP BY T1.CLASS_ID ";
//$sql1	=	" SELECT CLASS_ID,`GroupId` as GROUP_ID,`Grp_Name` as GROUP_NAME,Standard AS STANDARD,Section AS SECTION,count(`ADMISSION_ID`) as TOT_STUDENT FROM `v_studentlist` WHERE `Year_Id` = '".$yearId."' group by `GroupId`";
$sql1	=	" SELECT `class_id` as CLASS_ID, `GroupId` as GROUP_ID,`CLASSSEC` as CLASSSEC, `Standard` as STANDARD, `Section` as SECTION, COUNT(class_id) AS TOT_STUDENT FROM `v_studentlist` WHERE Year_Id = '".$yearId."' GROUP BY CLASSSEC order by class_id ";
$exe1	=	$mysqli->query($sql1);

$subpaid = 0;
$subbalance = 0;
$subamount = 0;

while($row1 = $exe1->fetch_assoc() ) {
	$sql2	=	"SELECT sum(`totAmount`) as TOT_AMOUNT,sum(`Balance_Amount`) AS BALANCE FROM `feestatus` where `classId` = '".$row1['CLASS_ID']."' AND Paid_Type != '0' AND Year_Id = '".$yearId."'";
	$exe2	=	$mysqli->query($sql2);
	$row2	=	$exe2->fetch_assoc();

	$sql4	=	"SELECT  `CLASS_ID` , COUNT( DISTINCT  `ADMISSION_ID` ) as CNT FROM  `fee_receipt` where status = 0 AND CLASS_ID = '".$row1['CLASS_ID']."' AND YEAR_ID = '".$yearId."' GROUP BY  `CLASS_ID`  ";	
	$exe4	=	$mysqli->query($sql4);
	$row4	=	$exe4->fetch_assoc();	

	$tmp	=	array();
	$tmp['STD_SEC']      = $row1['CLASSSEC'];
	$tmp['TOT_STUDENT']  = $row1['TOT_STUDENT'];
	$tmp['PAID_STUDENT'] = $row4['CNT'];
	$tmp['TOT_AMOUNT']   = $row2['TOT_AMOUNT'];	
	$tmp['BALANCE']      = $row2['BALANCE'];
	$tmp['SEC_PAID']     = $row2['TOT_AMOUNT'] - $row2['BALANCE'];
	$tmp['NON_PAID']	 = $tmp['TOT_STUDENT'] - $tmp['PAID_STUDENT'];
	$subamount  += $tmp['TOT_AMOUNT'];
	$subpaid	+= $tmp['SEC_PAID'];
	$subbalance += $tmp['BALANCE'];	
	$arr[] = $tmp;
	
}

$narr = array_merge(array('result'=>$arr), array('SUB_TOTAL' => $subamount, 'SUB_PAID_TOTAL' => $subpaid,'SUB_BAL_TOTAL' => $subbalance));

$json_response = json_encode($narr);

// # Return the response
echo $json_response;
exit;



?>