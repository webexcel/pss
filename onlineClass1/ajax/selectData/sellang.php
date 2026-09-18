<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);

	$selclass = "SELECT *, langId as id, langName as text FROM tbl_2ndlanguage WHERE Status='1' order by langId";	
	$selclassexe = mysql_query($selclass);
	
	$arr[]	=	array('langId' => '', 'langName' => 'SELECT', 'status' => 1, 'id' => '', 'text' => 'SELECT');
	while($row = mysql_fetch_assoc($selclassexe)){
		$langId	=	$row['langId'];
		$langName	=	$row['langName'];
		$status		=	$row['status'];
		$id			=	$row['id'];
		$text		=	$row['text'];
		array_push($arr, array('langId' => $langId, 'langName' => $langName, 'status' => $status, 'id' => $id, 'text' => $text ) );
		
		$classsec[] = $row;
	}
	
	if(empty($classsec)) {
		$classsec['message'] = 'No records found';
	}
	
	print json_encode($arr);



?>