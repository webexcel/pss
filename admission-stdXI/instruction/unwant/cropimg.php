<?php
	$base64img = explode(",",$_POST['imagdata']);
	$_POST['imagdata']=$base64img[1];
	$title = rand(1111,9999); 
	$filepathtemp = 'cropimg/';
	$insert_array['endordement_signature_img'] ='crop_img'.$title.'_'.time().'.jpg';
	$newBase = str_replace(' ', '+', $_POST['imagdata']);
	$binary = base64_decode($newBase);
	$file = fopen($filepathtemp.$insert_array['endordement_signature_img'], 'wb');
	fwrite($file, $binary);
	fclose($file);
	echo $insert_array['endordement_signature_img'];
	exit();
?>