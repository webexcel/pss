<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);

	$selclass = "SELECT *, groupId as id, groupName as text FROM tbl_group WHERE Status='1' order by groupId";	
	$selclassexe = mysql_query($selclass);
	mysql_num_rows($selclassexe);

	$arr[]	=	array('groupId' => '', 'groupName' => 'SELECT', 'status' => 1, 'id' => '', 'text' => 'SELECT');
	
	while($row = mysql_fetch_assoc($selclassexe)){
		$groupId	=	$row['groupId'];
		$groupName	=	$row['groupName'];
		$status		=	$row['status'];
		$id			=	$row['id'];
		$text		=	$row['text'];
		array_push($arr, array('groupId' => $groupId, 'groupName' => $groupName, 'status' => $status, 'id' => $id, 'text' => $text ) );
		$classsec[] = $row;
	}
	
	print json_encode($arr);
	?>