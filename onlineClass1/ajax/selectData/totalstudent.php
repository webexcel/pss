<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
$result = mysql_query("SELECT SUM(`countstu`) as gtotal FROM `v_countstu`");
//$result = mysql_query("SELECT * FROM v_countStu");

while($row = mysql_fetch_array($result)) {
	
	$classsec[] = $row;
}

	print json_encode($classsec);
	


	?>