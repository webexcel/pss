<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	
	
$result= mysql_query("CALL stu_list();") or die(mysql_error()); 
while($row = mysql_fetch_assoc($result))
{
 
$classsec[] = $row; 
  
}  
mysql_close($con); 	

	print json_encode($classsec);


	?>