<?php
	$sender = "STBEDE";
	$mobile = "9965617544";
	$message = urlencode('Hi Mani !@#$%^&*()');
	$URL = "http://www.myvaluefirst.com/smpp/sendsms?username=schooltree&password=Schooltree@123&to=".$mobile."&from=".$sender."&text=".$message;
	$ch = curl_init();	
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"msgType=UC");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 20000);
    $buffer = curl_exec($ch);
    curl_close($ch);
	/*$ch = curl_init();		
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"msgType=UC");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 20000);
    $buffer = curl_exec($ch);
    curl_close($ch);*/	
	echo   $buffer;
?>