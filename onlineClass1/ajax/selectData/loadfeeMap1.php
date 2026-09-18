<?php
require_once('../../login/auth.php');

require_once('../../login/config.php');
error_reporting(0);


//$_GET = json_decode(file_get_contents('php://input'), true);
//@extract($_GET);

$adno			=	$_GET['adno'];
$feeGroupID	=	$_GET['feegrpid'];



//$abslist =	"SELECT * FROM v_fees WHERE feehead = '$feeGroup' ";	
$abslist =	"SELECT * FROM feegroupmapping, feeheads, feetype WHERE feetype.FeeTypeId = feeheads.FeeTypeId AND feegroupmapping.FeeHeadId = feeheads.feeheadId AND  feegroupmapping.FeeGrpID = '$feeGroupID' "; 
$abslistexe	= mysql_query($abslist);
$num_rows	=	mysql_num_rows($abslistexe);
if( $num_rows > 0 ) {
	while($row = mysql_fetch_array($abslistexe)){
		$data[] = $row;
	}
	//print json_encode($data);
} else {
	$data[] = "No records found";
}
print json_encode($data);	
?>