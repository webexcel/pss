<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');
session_start();
$_POST	=	json_decode(file_get_contents('php://input'), true);

$yearId	=	$_SESSION['YEAR_ID'];
	
if(isset($_POST['section'])){
	$section	=	$_POST['section'];
}else {
	$section	=	"";
}

	if( $section == "" ) {
		$query	=	" SELECT * from v_studentlist where van_map = '1' and Year_Id = '".$yearId."'  ORDER BY `CLASS_ID` ASC ";			
	}else {
		$query	=	" SELECT * from v_studentlist where van_map = '1' and `Year_Id` = '".$yearId."' AND `CLASS_ID` = '".$section."'  ORDER BY `CLASS_ID` ASC ";	
	}
$result	=	mysqli_query($con, $query);
$arr = array();
	if($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
			$arr[]		=	$row;
		}
	}

$json_response = json_encode($arr);
echo $json_response;


?>