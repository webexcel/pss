<?php

$dbconnect = new  mysqli('schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com','main','P@mani4u','pssenior'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

?>
