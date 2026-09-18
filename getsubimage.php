<?php
	$dbconnect =new  mysqli('localhost','root','P@mani4u','pss_website');
	if($dbconnect->connect_error){
		die('error'.$dbconnect->connect_error);
	}
	$query = "select * from gallery where  GalCatID = ".$_GET['catid'];
	//$query = "select * from gallery where  GalID = 1";
	$data=[];
	if($result = mysqli_query($dbconnect,$query)){
		$count=0;
		$json=[];
		while($row = mysqli_fetch_assoc($result)){
		     $json[$count]['href'] = $row['GalPath'];
		     $json[$count]['title'] = 'Gallery';
		     $count= $count+1;
		}
		$data['result']=true;
		$data['data']=$json;
		echo json_encode($data);		
	}else{
		$data['result']=true;
		$data['data']='no data found';
		echo json_encode($data);	
	}
	exit();
?>
