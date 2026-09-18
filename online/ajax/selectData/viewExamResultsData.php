<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'palert');
define('DB_USERNAME', 'root');

$db_pass	=	($_SERVER['HTTP_HOST']=='localhost') ? '' : 'webexcel@123';
define('DB_PASSWORD', $db_pass);


$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$adno	=	$_GET['adno'];

$sqlTamilAvg	=	"SELECT AVG(`firstLanguage`) AS tamilAvg FROM `marks`";
$exeTamilAvg	=	mysqli_query($con, $sqlTamilAvg);
$resTamilAvg	=	mysqli_fetch_array($exeTamilAvg);
$tamilAvg		=	$resTamilAvg['tamilAvg'];

$sqlEnglishAvg	=	"SELECT AVG(`secondLanguage`) AS englishAvg FROM `marks`";
$exeEnglishAvg	=	mysqli_query($con, $sqlEnglishAvg);
$resEnglishAvg	=	mysqli_fetch_array($exeEnglishAvg);
$englishAvg		=	$resEnglishAvg['englishAvg'];

$sqlMathsAvg	=	"SELECT AVG(`maths`) AS mathsAvg FROM `marks`";
$exeMathsAvg	=	mysqli_query($con, $sqlMathsAvg);
$resMathsAvg	=	mysqli_fetch_array($exeMathsAvg);
$mathsAvg		=	$resMathsAvg['mathsAvg'];

$sqlScoenceAvg	=	"SELECT AVG(`science`) AS scienceAvg FROM `marks`";
$exeScoenceAvg	=	mysqli_query($con, $sqlScoenceAvg);
$resScoenceAvg	=	mysqli_fetch_array($exeScoenceAvg);
$scienceAvg		=	$resScoenceAvg['scienceAvg'];

$sqlSScoenceAvg	=	"SELECT AVG(`socialScience`) AS sScienceAvg FROM `marks`";
$exeSScoenceAvg	=	mysqli_query($con, $sqlSScoenceAvg);
$resSScoenceAvg	=	mysqli_fetch_array($exeSScoenceAvg);
$sScienceAvg	=	$resSScoenceAvg['sScienceAvg'];



$sql	=	"SELECT A.`CLASSSEC`, A.`STUDENTNAME`, B.`firstLanguage`, B.`secondLanguage`, B.`maths`, B.`science`, B.`socialScience`, B.`total`, B.`grade`, B.`status` FROM  `master` A, `marks` B WHERE A.`ADNO` = B.`ADNO` AND A.`ADNO` = '".$adno."'";
$result =	mysqli_query($con, $sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	
	
	/*
	$point	=	array('name' => $r['STUDENTNAME']." [".$r['CLASSSEC']."]");
	array_push($rows, $point);
	$point	=	array('y' => $r['firstLanguage'], 'label' => 'Tamil');
	array_push($rows, $point);
	$point	=	array('y' => $r['secondLanguage'], 'label' => 'English');
	array_push($rows, $point);
	$point	=	array('y' => $r['maths'], 'label' => 'Maths');
	array_push($rows, $point);
	$point	=	array('y' => $r['science'], 'label' => 'Science');
	array_push($rows, $point);
	$point	=	array('y' => $r['socialScience'], 'label' => 'Social Science');
	array_push($rows, $point);
	*/
	
	$point	=	array('name' => $r['STUDENTNAME'], 'tamil' => $r['firstLanguage'].'||'.$tamilAvg, 'english' => $r['secondLanguage'].'||'.$englishAvg, 'maths' => $r['maths'].'||'.$mathsAvg, 'science' => $r['science'].'||'.$scienceAvg, 'sscience' => $r['socialScience'].'||'.$sScienceAvg);
	$rows	=	$point;
	//array_push($rows, $point);

}

$retJSON	=	json_encode($rows, JSON_NUMERIC_CHECK);
print $retJSON;

?>