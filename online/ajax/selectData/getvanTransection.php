<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();
$data	=	json_decode(file_get_contents('php://input'), true);
$yearId	= $_SESSION['YEAR_ID'];
$db 	= $_SESSION['SESS_MEMBER_DBNAME'];
$adno   = $data['aroute'];
		
	$sql	=	"SELECT * FROM  van_feetransection where `admission_id` = '".$adno."' AND Year_Id = '".$yearId."'";	
	
	$result	=	$mysqli->query($sql);
	$arr = array();
	if($result){
	while( $row = $result->fetch_assoc() ) {		
		$tmp	=	array();
		$tmp['id'] 		= $row['id'];
		$tmp['adno'] 	= $row['admission_id'];
		$tmp['name'] 	= $row['name'];
		$tmp['class'] 	= $row['classs'];
		$tmp['route'] 	= $row['route_name'];
		$tmp['stage'] 	= $row['stage_name'];
		$tmp['type'] 	= $row['type'];
		$tmp['date'] 	= $row['date'];
		$tmp['amount'] 	= $row['amount'];
		

		$arr[]		        = $tmp;
		}
	}
	else
	{
		echo $mysqli->error;
	}
	
//$arr =array_merge($arrs,'U_PDF' => $_SESSION['SESS_MEMBER_DBNAME']);
$narr = array_merge(array('result'=>$arr), array('U_PDF' => $db));
$json_response = json_encode($narr);	
	
# JSON-encode the response
//$json_response = json_encode($arr);
// # Return the response
echo $json_response;


?>