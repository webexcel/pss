<?php
require_once('../../login/auth.php');

require_once('../../login/config.php');
error_reporting(0);


$_POST = json_decode(file_get_contents('php://input'), true);
@extract($_POST);


//$abslist =	"SELECT * FROM v_fees WHERE GroupId = '$feeGroup' ";	
$abslist =	"SELECT * FROM feegroupmapping, feeheads, feetype WHERE feetype.FeeTypeId = feegroupmapping.FeeTypeId AND feegroupmapping.FeeHeadId = feeheads.feeheadId AND  feegroupmapping.FeeGrpID = '$feeGroup' "; 
$abslistexe	= mysql_query($abslist);
$num_rows	=	mysql_num_rows($abslistexe);
if( $num_rows > 0 ) {
	while($row = mysql_fetch_array($abslistexe)){
		$data[] = $row;
	}
	print json_encode($data);
} else {
	echo "No records found";
}
	
?>