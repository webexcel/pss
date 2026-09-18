<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
$arr	=	[];
/*
$query1		=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND T1.RECEIPT_DATE = CURDATE() ";
$exequery1	=	$mysqli->query($query1);
$res1		=	$exequery1->fetch_assoc();
$arr['DATE']=	$res1['AMT'];

$query2		=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND MONTH(T1.RECEIPT_DATE) = MONTH(CURDATE()) ";
$exequery2	=	$mysqli->query($query2);
$res2		=	$exequery2->fetch_assoc();
$arr['MONTH']=	$res2['AMT'];

$query3	=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND YEAR(T1.RECEIPT_DATE) = YEAR(CURDATE()) ";
$exequery3	=	$mysqli->query($query3);
$res3		=	$exequery3->fetch_assoc();
$arr['YEAR']=	$res3['AMT'];

$query4     =	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND WEEK(T1.RECEIPT_DATE) = WEEK(CURDATE()) ";
$exequery4	=	$mysqli->query($query4);
$res4		=	$exequery4->fetch_assoc();
$arr['WEEK']=	$res4['AMT'];
*/

$query1		=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND T1.RECEIPT_DATE = CURDATE() ";
$exequery1	=	$mysqli->query($query1);
$res1		=	$exequery1->fetch_assoc();
$arr['DATE']=	$res1['AMT'];

$query2		=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND MONTH(T1.RECEIPT_DATE) = MONTH(CURDATE()) ";
$exequery2	=	$mysqli->query($query2);
$res2		=	$exequery2->fetch_assoc();
$arr['MONTH']=	$res2['AMT'];

//$query3	=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND YEAR(T1.RECEIPT_DATE)";
$query3	=	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND YEAR(T1.RECEIPT_DATE) BETWEEN '".$_SESSION['Sdate']."' AND '".$_SESSION['Edate']."' ";
$exequery3	=	$mysqli->query($query3);
$res3		=	$exequery3->fetch_assoc();
$arr['YEAR']=	$res3['AMT'];

$query4     =	" SELECT SUM(Amount) AS AMT FROM fee_receipt T1, fee_transanction T2 WHERE T1.RECEIPT_ID = T2.RECEIPT_ID AND T1.STATUS = 0 AND WEEK(T1.RECEIPT_DATE) = WEEK(CURDATE()) ";
$exequery4	=	$mysqli->query($query4);
$res4		=	$exequery4->fetch_assoc();
$arr['WEEK']=	$res4['AMT'];


$query5      =	" SELECT SUM(`AMOUNT`) AS AMT FROM `van_feetransection`";
$exequery5	 =	$mysqli->query($query5);
$res5		 =	$exequery5->fetch_assoc();
$arr['VAN']  =	$res5['AMT'];

$query6        =	" SELECT SUM(`amount`) AS AMT FROM `fee_fine`";
$exequery6	   =	$mysqli->query($query6);
$res6		   =	$exequery6->fetch_assoc();
$arr['OTHER']  =	$res6['AMT'];


$json_response = json_encode($arr);

// # Return the response
echo $json_response;
exit;



?>