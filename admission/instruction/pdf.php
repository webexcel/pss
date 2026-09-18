<?php
require_once('configi.php');
$id		= $_GET['ids'];
$query	= mysqli_query($dbconnect,"select * from application where id = '".$id."' ");
$row 	= mysqli_fetch_assoc($query);

$originalDate = $row['dob'];
$dob  		  = date("d-m-Y", strtotime($originalDate));
$classsec1    	  = $row['class1'].'-'.$row['sec1'];
$classsec2         = $row['class2'].'-'.$row['sec2'];
//$religion 	  = $row['community'].'-'.$row['religion'].'-'.$row['nationality'];		
?>

<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<script>
	function myFunction() {
		window.print();
	}
</script>
<style>
table, th, td {
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;  
} 

</style>
<style media="print">
 @page {
  size: auto;
  margin: 0px;
       }
</style>
<body onload="myFunction()">

<div class="container" style="padding:50px">          
		<div class="row">
			<div class="col-xs-12">
				
				<div class="col-xs-2">
					<!--<img src="Images/logo1.png" alt="" width="80px" height="80px">-->
				</div>
				<div class="col-xs-8">
					<div class="invoice-title" style="text-align:center">
						<h2><b>P.S.Senior Secondary School<</h4>						
						<h3>STUDENT APPLICATION </h5>
					
					</div>
				</div>
				<div class="col-xs-2">
				</div>
			</div>	
		</div>
		
				<br><br><br>
			<div class="container">
				
				<div class="row">
					<div class="col-xs-12">
						<table class="table">
					<tr>
						<th>1 . APPLICATION NO</th>
						<td colspan="2">: <?php echo $row['fno']; ?></td>
					</tr>
					<tr>
						<th>2 . NAME OF THE CHILD</th>
						<td colspan="2">: <?php echo $row['name']; ?></td>
						
					</tr>
					<tr>
						<th>3 . DATE OF BIRTH</th>
						<td colspan="2">: <?php echo $dob; ?></td>
					</tr>
					<tr>
						<th>4 . BLOOD GROUP</th>
						<td colspan="2">: <?php echo $row['bg']; ?></td>
					</tr>
					<tr>
						<th>5 . APPLIED FOR</th>
						<td colspan="2">: <?php echo $row['applied']; ?></td>
					</tr>
					<tr>
						<th>6 . GENDER</th>
						<td colspan="2">: <?php echo $row['gender']; ?></td>
					</tr>
					<tr>
						<th>7 . NATIONALITY</th>
						<td colspan="2">: <?php echo $row['nationality']; ?></td>
					</tr>
					<tr>
						<th>8. RELIGION</th>
						<td colspan="2">: <?php echo $row['religion']; ?></td>
					</tr>
					<tr>
						<th>9 . COMMUNITY</th>
						<td colspan="2">: <?php echo $row['community']; ?></td>
					</tr>
					<tr>
						<th>10 . MOTHER TONGUE</th>
						<td colspan="2">: <?php echo $row['mt']; ?></td>
					</tr>
					<tr>
						<th>11 . EMIS NO</th>
						<td colspan="2">: <?php echo $row['emis']; ?></td>
					</tr>
					<tr>
						<th>12 . AADHAR NO</th>
						<td colspan="2">: <?php echo $row['aadhar']; ?></td>
					</tr>
					<tr>
						<th>13 . CONTACT NO</th>
						<td colspan="2">: <?php echo $row['contact']. ',' .$row['contact1'];?></td>
					</tr>
					<tr>
						<th>14 . LANDLINE NO</th>
						<td colspan="2">: <?php echo $row['landline'];?></td>
					</tr>
					<tr>
						<th>15 . EMAIL</th>
						<td colspan="2">: <?php echo $row['email']; ?></td>
					</tr>
					</table>
					<h4 style="text-align:center;padding-top:80px">ADDRESS</h4>
					<table style="width:100%" border = "1" cellpadding = "5" cellspacing = "5">
							<tr>								
								<th>PERMANENT ADDRESS :</th>						
							</tr>
							<tr border = "1">
								<td>
								<?php
								if(empty($row['addressP']))
								{
									echo 'Nil';
								}else{
									echo $row['addressP'];
								}
								 ?></td>
								
							</tr>
					</table>
					<table style="width:100%" border = "1" cellpadding = "5" cellspacing = "5">
							<tr>								
								<th>RESIDENTIAL ADDRESS :</th>						
							</tr>
							<tr border = "1">
								
								<td>
								<?php
								if(empty($row['addressR']))
								{
									echo 'Nil';
								}else{
									echo $row['addressR'];
								}
								 ?></td>
							</tr>
					</table>
					
					<h4 style="text-align:center;padding-top:185px">PARENT DETAILS</h4>
					<table style="width:100%" border = "1" cellpadding = "5" cellspacing = "5">
							<tr>
								<th>PARENT INFO</th>
								<th>FATHER DETAILS</th>
								<th>MOTHER DETAILS</th>
														
							</tr>
							<tr border = "1">
								<td><b>NAME</b></td>
								<td>
								<?php
								if(empty($row['fname']))
								{
									echo 'Nil';
								}else{
									echo $row['fname'];
								}
								 ?></td>
								<td>
								<?php
								if(empty($row['mname']))
								{
									echo 'Nil';
								}else{
									echo $row['mname'];
								}
								 ?></td>
							</tr>
							<tr>
								<td><b>QUALIFICATION</b></td>
								
								<td>
								<?php
								if(empty($row['fquali']))
								{
									echo 'Nil';
								}else{
									echo $row['fquali'];
								}
								 ?></td>								
								<td>
								<?php
								if(empty($row['mquali']))
								{
									echo 'Nil';
								}else{
									echo $row['mquali'];
								}
								 ?></td>
							</tr>
							<tr>
								<td><b>OCCUPATION</b></td>
								
								<td>
								<?php
								if(empty($row['focc']))
								{
									echo 'Nil';
								}else{
									echo $row['focc'];
								}
								 ?></td>								
								<td>
								<?php
								if(empty($row['mocc']))
								{
									echo 'Nil';
								}else{
									echo $row['mocc'];
								}
								 ?></td>
							</tr>
							<tr>
								<td><b>DETAILS OF THE OCCUPATION</b></td>
								
								<td>
								<?php
								if(empty($row['foccdetails']))
								{
									echo 'Nil';
								}else{
									echo $row['foccdetails'];
								}
								 ?></td>								
								<td>
								<?php
								if(empty($row['moccdetails']))
								{
									echo 'Nil';
								}else{
									echo $row['moccdetails'];
								}
								 ?></td>
							</tr>
							<tr>
								<td><b>ANNUAL INCOME</b></td>
								
								<td>
								<?php
								if(empty($row['fincome']))
								{
									echo 'Nil';
								}else{
									echo $row['fincome'];
								}
								 ?></td>								
								<td>
								<?php
								if(empty($row['mincome']))
								{
									echo 'Nil';
								}else{
									echo $row['mincome'];
								}
								 ?></td>
							</tr>
							
							
					</table>
					
					<h4 style="text-align:center; text-align:center;padding-top:20px">NAME OF THE SISTER/BROTHER (SIBLINGS) STUDYING IN OUR SCHOOL</h4>
					<table style="width:100%" border = "1" cellpadding = "5" cellspacing = "5">
							<tr>
								<th>ADMISSION NO</th>
								<th>NAME OF STUDENT</th>
								<th>STD & SEC</th>
														
							</tr>
							<tr border = "1">
								<td>
								<?php
								if(empty($row['adno1']))
								{
									echo 'Nil';
								}else{
									echo $row['adno1'];
								}
								 ?></td>
								<td>
								<?php
								if(empty($row['sname1']))
								{
									echo 'Nil';
								}else{
									echo $row['sname1'];
								}
								 ?></td>
								<td>
								<?php
								if(empty($classsec1))
								{
									echo 'Nil';
								}else{
									echo $classsec1;
								}
								 ?></td>
							</tr>
							<tr>
								<td>
								<?php
								if(empty($row['adno2']))
								{
									echo 'Nil';
								}else{
									echo $row['adno2'];
								}
								 ?></td>
								
								<td>
								<?php
								if(empty($row['sname2']))
								{
									echo 'Nil';
								}else{
									echo $row['sname2'];
								}
								 ?></td>								
								<td>
								<?php
								if(empty($classsec2))
								{
									echo 'Nil';
								}else{
									echo $classsec2;
								}
								 ?></td>
							</tr>
					</table>	
					
					<h4 style="text-align:center">WHETHER THE PARENT IS AN ALIMNUS OF OUR SCHOOL</h4>
					<table style="width:100%" border = "1" cellpadding = "5" cellspacing = "5">
							<tr>
								<th>NAME</th>
								<th>YEAR OF ADMISSION </th>
								<th>CLASS</th>
                                <th>YEAR OF COMPLETION  </th>                             
								<th>CLASS</th>
														
							</tr>
							<tr border = "1">
								<td>
								<?php
								if(empty($row['aname']))
								{
									echo 'Nil';
								}else{
									echo $row['aname'];
								}
								 ?></td>
								<td>
								<?php
								if(empty($row['yadno']))
								{
									echo 'Nil';
								}else{
									echo $row['yadno'];
								}
								 ?></td>
								<td>
								<?php
								if(empty($row['yclass']))
								{
									echo 'Nil';
								}else{
									echo $row['yclass'];
								}
								 ?></td>
								 <td>
								<?php
								if(empty($row['ycom']))
								{
									echo 'Nil';
								}else{
									echo $row['ycom'];
								}
								 ?></td>
								 <td>
								<?php
								if(empty($row['cclass']))
								{
									echo 'Nil';
								}else{
									echo $row['cclass'];
								}
								 ?></td>
							</tr>
							
					</table>	
				
				
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">	
				<h4 style="text-align:center">DECLARATION BY THE PARENT/GUARDIAN</h4>
			   <p style="text-align:justify">I/We hereby certify that the above information provided by me/us is correct, 
			   if the information is found to be 
					incorrect or false, the ward shall be automatically disqualified from Selection/Admission without any 
					correspondance. I/We understand that the Application/Registration does not guarantee admission to my ward. I 
					agree to abide by the rules and regulations of the institution.</p>

				</div>
			</div>	



			<div class="row">
				<div class="col-xs-12" style="border:1px solid gray;">	
					<div class="col-xs-6">
						<h6 style="padding-left:10px;">PLACE : </h6>
						<h6 style="padding-left:10px;">DATE :</h6>
					</div>
					<div class="col-xs-6">
						<h6 style="text-align:right;padding-right:10px;">PARENT/ GUARDIAN SIGNATURE</h6>
					</div>
				</div>
			</div>	
		
		
			<!--<div class="row">
				<div class="col-xs-12" style="border:1px solid gray;">	
				<h4 style="text-align:center">FOR OFFICE USE ONLY</h4>
					<div class="col-xs-6">
						<p>Receipt No. : __________________</p><br>
						<p>Rejected /Admitted to Standard :_________________________________</p>
					</div>
					
				</div>
			</div>	-->
		</div>
				

</div>


