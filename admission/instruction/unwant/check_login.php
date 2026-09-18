<?php
$dbconnect = new  mysqli('localhost','main','P@mani4u','st_patricks'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

$mobile		=	trim($_POST['mobile']);
$dob		=	trim($_POST['strDOB1']);

$sql = "SELECT * FROM `application_temp` where contact = '".$mobile."' and  dob = '".$dob."'";
$query	= mysqli_query($dbconnect,$sql);
$row 	= mysqli_fetch_assoc($query);
$status = $row['status'];
$id = $row['id'];
 $row_cnt = $query->num_rows;
if( $row_cnt == 0 ) {
	header("Location: photo.html?mobile=$mobile&dob=$dob");
}
else{		
    if($status == 1){
		header("Location: pdf.php?ids=$id");//success
	}
	else{
		header("Location: print.php?id=$id");//ready
	}
}



?>