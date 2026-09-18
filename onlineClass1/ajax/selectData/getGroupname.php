<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();


$data	 =	json_decode(file_get_contents('php://input'), true);

$yearId	 =	$_SESSION['YEAR_ID'];

$sql	=	"SELECT * FROM `feegroup` WHERE `feeGroupStatus` = '1' and `Year_Id` = '".$yearId."'";
$exe	=	$mysqli->query($sql);
$cnt	=	$exe->num_rows;
$arr	=	array();

if( $cnt > 0 ) {
	while( $row = $exe->fetch_assoc() ) {		
		$arr[]	=	$row;
	}
}
$json_response = json_encode($arr);
echo $json_response;
exit;



?>