
<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$arr	=	array();

if(!empty($data)) {
	$aid	=	trim($data['uStudent']['eid']);
	$ahead	=	trim($data['uStudent']['efeehead']);
	
	$sqlUpdHead	=	"UPDATE `tbl_feetype` SET `feetype` = '".$ahead."' WHERE `fid` = '".$aid."' ";		
	$exeUpdHead	=	$mysqli->query($sqlUpdHead);	
	$arr['message']	=	"SUCCESS";
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>