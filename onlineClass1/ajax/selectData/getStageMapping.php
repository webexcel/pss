<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
$yearId	=	$_SESSION['YEAR_ID'];
	$arr = [];	
	
	$sql	=	"SELECT * FROM `van_stage` where `Year_Id` = '".$yearId."'  ORDER BY `route` ASC";		
	
	$result	=	$mysqli->query($sql);
	
	while( $row = $result->fetch_assoc() ) {		
		$tmp	=	array();
		$tmp['id'] 	    	= $row['id'];
		$tmp['dname'] 	    = $row['dname'];
		$tmp['cname'] 	    = $row['cname'];
		$tmp['route'] 	    = $row['route'];
		$tmp['stage_name']  = $row['stage_name'];
		$tmp['intime'] 	    = $row['intime'];
		$tmp['outtime'] 	= $row['outtime'];
		$tmp['fc'] 			= $row['fc'];
		$tmp['vno'] 		= $row['vno'];
		$tmp['stage_in'] 	= $row['stage_in'];
		$tmp['stage_out'] 	= $row['stage_out'];
		$tmp['contact'] 	= $row['contact'];
		$tmp['term_I']      = $row['term_I'];	
		$tmp['term_II']  	= $row['term_II'];	
		$tmp['term_III']  	= $row['term_III'];		
		$tmp['amount']      = $row['amount'];		
		$arr[]		        = $tmp;
	}

# JSON-encode the response
$json_response = json_encode($arr);
// # Return the response
echo $json_response;


?>