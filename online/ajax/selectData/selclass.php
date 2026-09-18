<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);

	//$selclass = "SELECT DISTINCT(CLASSSEC) FROM master";	
	$selclass = "SELECT *, CLASS_ID as id, CONCAT(Standard,' - ',Section) as text FROM tbl_class WHERE Status='1' order by CLASS_ID";	
	$selclassexe = mysql_query($selclass);
	
	//$classsec[] = array("CLASS_ID" => "", "Standard" => "SELECT", "Section" => "CLASS", "id"=>"", "text" => "SELECT - CLASS" );
	while($row = mysql_fetch_assoc($selclassexe)){
		$classsec[] = $row;
	}
	print json_encode($classsec);
	?>