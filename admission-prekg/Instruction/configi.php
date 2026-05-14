<?php

$dbconnect = new  mysqli('schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com','main','P@mani4u','pss_website'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

?>
