<?php
error_reporting(0);

require_once('../../login/auth.php');
require_once('../../login/config.php');


$_POST = json_decode(file_get_contents('php://input'), true);



$FeeGrpMapId	=	$_POST['FeeGrpMapId'];
$feeAmount		=	$_POST['feeAmount'];

$data['FeeGrpMapId'] = $_POST['FeeGrpMapId'];
$data['feeAmount'] = $_POST['feeAmount'];

$sql = "UPDATE feegroupmapping SET feeAmount = '".$feeAmount."' WHERE FeeGrpMapId = '".$FeeGrpMapId."'";
$res = mysql_query($sql);

if(!$res) {
	echo "error";
} else {
	while($row = mysql_fetch_array($res)){
		$data = $row;
	}
	print json_encode($data);
}

	
?>