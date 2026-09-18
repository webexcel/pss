<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);

	$selclass = "SELECT * FROM tbl_stutype WHERE Status='1' order by stuTypeId";	
	$selclassexe = mysql_query($selclass);
	
	while($row = mysql_fetch_array($selclassexe)){
		$classsec[] = $row;
	}
	if(empty($classsec)) {
		$classsec['message'] = 'No records found';
	}	
	print json_encode($classsec);

?>