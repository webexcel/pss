<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');


$_POST	=	json_decode(file_get_contents('php://input'), true);

if( isset($_POST['section']) ) {
	$section	=	trim($_POST['section']);
} else {
	$section	=	"";
}

if( isset($_POST['bills']) ) {
	$bills	=	trim($_POST['bills']);
} else {
	$bills	=	"";
}

//$bills 		= trim($_POST['bills']);
$yearId	    =	$_SESSION['YEAR_ID'];

if( $section == "" && $bills == "" ) 
{
	$query	=	" SELECT `CLASS_ID`,`CLASSSEC` AS STD_SEC,`NAME`,`FATHER_NAME`,`ADMISSION_ID` FROM v_studentlist  WHERE Year_Id = '".$yearId."' ORDER BY CLASS_ID, NAME";
} else {
	 $query	=	" SELECT v_studentlist.`CLASS_ID`,v_studentlist.`CLASSSEC` AS STD_SEC,v_studentlist.`NAME`,v_studentlist.`FATHER_NAME`,v_studentlist.`ADMISSION_ID`,v_fees.billBookId AS billid FROM v_studentlist  join v_fees on v_studentlist.ADMISSION_ID = v_fees.Admission_No WHERE v_studentlist.Year_Id = '".$yearId."' AND v_studentlist.CLASS_ID = '".$section."' AND v_fees.billBookId = '".$bills."' ORDER BY CLASS_ID, NAME ";
}

$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
	
		$arr[]		=	$row;
	}
}

# JSON-encode the response
$json_response = json_encode($arr);

echo $json_response;


exit;





?>
	