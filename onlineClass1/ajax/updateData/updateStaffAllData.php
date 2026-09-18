
<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	$_SESSION['YEAR_ID'];
$arr	=	array();

if( !empty($data) ) {
	$scode	=	trim($data['uStudent']['eCode']);
	$sname	=	trim($data['uStudent']['eName']);
	$sdept	=	trim($data['uStudent']['eDept']);
	$squali	=	trim($data['uStudent']['eFathereQualiName']);
	
	
	$sqlSelOthers	=	"update p_staff_info set `staff_name` = '".$sname."' , `department` = '".$sdept."', `qualification` = '".$squali."' WHERE `staff_code` = '".$scode."' and Year_Id = '".$yearId."' ";
	$exeSelOthers	=	$mysqli->query($sqlSelOthers);
	if($exeSelOthers) {
		$arr['message']	=	"SUCCESS";
	} else {
		$arr['message']	=	"FAILED";
	}
	
} else {
	echo "is empty";
}

$json_response = json_encode($arr);
echo $json_response;
	
?>