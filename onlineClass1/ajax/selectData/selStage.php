<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');

$_POST	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	$_SESSION['YEAR_ID']; 

if( isset($_POST['busRoute']) ) {
	$route	=	trim($_POST['busRoute']);	
	$query	=	"SELECT id,`route`,`stage_name`, `Period`, `term_I`, `term_II`, `term_III`, `amount`, `status` FROM `van_stage` WHERE `route` = '".$route."' and Year_Id = '".$yearId."'";		
} 
$result	=	mysqli_query($con, $query);
//$arr = array();
if($result->num_rows > 0) {	
	while($row = $result->fetch_assoc()) {	
		$std['id'] 		= $row['id'];	
		$std['stage']	= $row['stage_name'];		
		$arr[]			= $std;
	}
}

$json_response = json_encode($arr);
echo $json_response;


?>