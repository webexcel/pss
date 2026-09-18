<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	


	   $abslist = "SELECT * FROM feegroup";	
		$abslistexe = mysql_query($abslist);
		while($row = mysql_fetch_array($abslistexe)){
	$data[] = $row;
	}
	//$data[] = $row;
	
	print json_encode($data);
	
	?>