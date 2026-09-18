<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);
$yearId	=	$_SESSION['YEAR_ID'];
$adno   =   $data['adno'];
		
	$sql	=	"SELECT t1.route,t1.stage_name,t1.term_I,t1.term_II,t1.term_III,t2.term1,t2.term2,t2.term3 FROM  van_stage t1 INNER JOIN van_stud_map t2 ON t1.id = t2.stage_id where t2.`adno` = '".$adno."' AND t1.Year_Id = '".$yearId."'";			
	$result	=	$mysqli->query($sql);
	$arr = array();
	while( $row = $result->fetch_assoc() ) {		
		$tmp	=	array();
		$tmp['term_I'] 		= $row['term_I'];
		$tmp['term_II'] 	= $row['term_II'];
		$tmp['term_III'] 	= $row['term_III'];
		$tmp['route'] 		= $row['route'];
		$tmp['stage'] 		= $row['stage_name'];
		$tmp['term1'] 		= $row['term1'];
		$tmp['term2']   	= $row['term2'];
		$tmp['term3']  		= $row['term3'];
		$tmp['total']		= $tmp['term1']+$tmp['term2']+$tmp['term3'];
		$arr[]		        = $tmp;
	}

	
	
# JSON-encode the response
$json_response = json_encode($arr);
// # Return the response
echo $json_response;


?>