<?php
//require_once('../../login/auth.php');
//require_once('../../login/config-mysqli.php');

require_once('../../login/auth.php');
require_once('../../login/config.php');

$_POST = json_decode(file_get_contents('php://input'), true);

$id			=	trim($_POST['id']);
$feeType	=	trim($_POST['feeType']);
$feeAmount	=	trim($_POST['feeAmount']);
$approveBy	=	trim($_POST['approveBy']);
$approveDate=	date('Y-m-d');

$sqlConUpdate	=	"UPDATE `feeconcession` SET `feeType` = '".$feeType."', `feeAmount` = '".$feeAmount."', `approveBy` = '".$approveBy."', approveDate = '".$approveDate."' WHERE `conID` = '".$id."'";
//$exeConUpdate	=	mysqli_query($con, $sqlConUpdate) or die(mysqli_error());
//$affRows		=	mysqli_affected_rows($con);


$exeConUpdate	=	mysql_query($sqlConUpdate) or die(mysql_error());
$affRows		=	mysql_affected_rows();


echo json_encode($affRows);

exit;



?>