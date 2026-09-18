<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');


$data	=	json_decode(file_get_contents('php://input'), true);


$sqlGroup	=	"SELECT `groupId` AS GROUP_ID, `groupName` AS GROUP_NAME FROM `tbl_group` WHERE `status` = 1 ";

//echo "SQL : " . $sqlFeeHeads . "<br />";

$exeGroup	=	$mysqli->query($sqlGroup);
$cntGroup	=	$exeGroup->num_rows;


//$arr['CLASS']	=	array();
if( $cntGroup > 0 ) {
	while( $row = $exeGroup->fetch_assoc() ) {		
		$arr[]	=	$row;
	}
} else {
	$arr['message']	=	"No records found";
}


$json_response = json_encode($arr);

// # Return the response
echo $json_response;

exit;



?>