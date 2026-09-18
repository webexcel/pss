<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'palert');
define('DB_USERNAME', 'root');

$db_pass	=	($_SERVER['HTTP_HOST']=='localhost') ? '' : 'webexcel@123';
define('DB_PASSWORD', $db_pass);


$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$adno	=	trim($_GET['adno']);
$lng		=	trim($_GET['lg']);
$lg		=	trim($_GET['lg']);

$classAndSection = trim($_GET['cls']);

if( $lg == 'tamil' ) {
	$lg	=	'firstLanguage';
}
if( $lg == 'english' ) {
	$lg	=	'secondLanguage';
}

$sqlSub	=	"SELECT COUNT(*) AS NoOfRows FROM `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`CLASSSEC` = '".$classAndSection."' AND  ".$lg." >= 0 AND ".$lg." <= 35 ";
$exeSub	=	mysqli_query($con, $sqlSub);
$resSub	=	mysqli_fetch_array($exeSub);
$tamilBelow35	=	$resSub['NoOfRows'];

$sqlSub	=	"SELECT COUNT(*) AS NoOfRows FROM `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`CLASSSEC` = '".$classAndSection."' AND  ".$lg." >= 35 AND ".$lg." <= 50 ";
$exeSub	=	mysqli_query($con, $sqlSub);
$resSub	=	mysqli_fetch_array($exeSub);
$tamilBelow50	=	$resSub['NoOfRows'];

$sqlSub	=	"SELECT COUNT(*) AS NoOfRows FROM `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`CLASSSEC` = '".$classAndSection."' AND  ".$lg." >= 50 AND ".$lg." <= 60 ";
$exeSub	=	mysqli_query($con, $sqlSub);
$resSub	=	mysqli_fetch_array($exeSub);
$tamilBelow60	=	$resSub['NoOfRows'];

$sqlSub	=	"SELECT COUNT(*) AS NoOfRows FROM `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`CLASSSEC` = '".$classAndSection."' AND  ".$lg." >= 60 AND ".$lg." <= 80 ";
$exeSub	=	mysqli_query($con, $sqlSub);
$resSub	=	mysqli_fetch_array($exeSub);
$tamilBelow80	=	$resSub['NoOfRows'];

$sqlSub	=	"SELECT COUNT(*) AS NoOfRows FROM `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`CLASSSEC` = '".$classAndSection."' AND  ".$lg." >= 80 AND ".$lg." <= 100 ";
$exeSub	=	mysqli_query($con, $sqlSub);
$resSub	=	mysqli_fetch_array($exeSub);
$tamilBelow100	=	$resSub['NoOfRows'];

$sql	=	"SELECT A.`CLASSSEC`, A.`STUDENTNAME`, B.`firstLanguage`, B.`secondLanguage`, B.`maths`, B.`science`, B.`socialScience`, B.`total`, B.`grade`, B.`status` FROM  `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`CLASSSEC` = '".$classAndSection."'";
$result =	mysqli_query($con, $sql);
$r = mysqli_fetch_array($result);

$point	=	array('name' => $r['CLASSSEC'] . " ". strtoupper($lng), 'count_0_35' => $tamilBelow35, 'count_35_50' => $tamilBelow50, 'count_50_60' => $tamilBelow60, 'count_60_80' => $tamilBelow80, 'count_80_100' => $tamilBelow100 );
$rows	=	$point;
	
$retJSON	=	json_encode($rows, JSON_NUMERIC_CHECK);
print $retJSON;


?>