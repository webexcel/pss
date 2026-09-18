<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
	$result = mysql_query("SELECT Standard, COUNT(`Standard`) AS NoStudent FROM `v_studentlist` GROUP BY `Standard` ORDER BY `CLASS_ID`, Standard, Section ASC");
	//$result = mysql_query("SELECT * FROM v_countStu");
	
	while($row = mysql_fetch_array($result)) {
		$classsec[] = $row;
	}

	print json_encode($classsec);
	


	?>