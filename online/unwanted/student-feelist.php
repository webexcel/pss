<?php 
session_start();
$dbconnect = new  mysqli('localhost','root','webexcel@123','demosch'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

$adno	= $_GET['stuid'];
		
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="style.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
<style>

table,tr, th,td{
	color:#fff;
}
</style>
<div class="container">
    
        <div class="card-header mx-auto bg-dark">
            <span class="logo_title mt-5">Student Name List</span>
        </div>
        <div class="card-body">
			<div class="table-responsive">
				<table class="table">
				<tbody> 
					<tr>
						<th>SNo</th>
						<th>CLASS</th>
						<th>ADNO</th>
						<th>NAME</th>
						<th>PAY</th>
	
					</tr>
					<?php 
					
					$countrow = 1;
					while($row = mysqli_fetch_assoc($result))
						{
						$class      = $row['CLASSSEC'];
						$adno       = $row['ADMISSION_ID'];
						$name       = $row['NAME'];
					echo "<tr>";
					echo "<td>" . $countrow++ . "</td>";
					echo "<td>" . $class . "</td>";
					echo "<td>" . $adno . "</td>";					
					echo "<td>" . $name . "</td>";
					echo '<td><a href="view-list.php?stuid='.$row['ADMISSION_ID'].'" class="btn btn-outline-danger float-left login_btn">Next</a></td>';
					echo "</tr>";  
					  
					}
					?>  
				 </tbody>   
				</table>
			</div>
       
    </div>
</div>