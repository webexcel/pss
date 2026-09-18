<?php
	session_start();
	//unset($_SESSION['EMAIL_ID']);
	
	if(session_destroy())
	{
		header("Location: index.php");
	}
?>