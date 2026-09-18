<?php
$dbconnect =new  mysqli('localhost','root','webexcel@123','online'); 
if($dbconnect->connect_error){

	die('error'.$dbconnect->connect_error);
}

$fno		 =	trim($_POST['fno']);
$dob		 =	trim($_POST['dob']);

$query	= mysqli_query($dbconnect,"select * from application where fno = '".$fno."' AND `dob` = '".$dob."'");

$row 	= mysqli_fetch_assoc($query);

$originalDate = $row['dob'];
$dob  		  = date("d-m-Y", strtotime($originalDate));
$classsec1    	  = $row['class1'].'-'.$row['sec1'];
$classsec2         = $row['class2'].'-'.$row['sec2'];
$religion 	  = $row['community'].'-'.$row['religion'].'-'.$row['nationality'];		
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

<div class="container" style="padding:50px;">          
		<div class="row">
			<div class="col-xs-12">
				
				<div class="col-xs-2">
					<img src="Images/Logo (3).jpg" alt="" width="100px" height="100px">
				</div>
				<div class="col-xs-10">
					<div class="invoice-title" style="text-align:center">
						<h4>ST.JOSEPH OF CLUNY MATRIC.HR.SEC.SCHOOL</h4>
						<h5>TINDIVANAM-604001</h5>
						<p>LKG Student Application</p>
					
					</div>
				</div>
			</div>	
		</div>
		
		
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<table style="width:100%">
					<tr>
						<th>1 . Application No</th>
						<td colspan="2">: <?php echo $row['fno']; ?></td>
					</tr>
					<tr>
						<th>2 . Name of the child</th>
						<td colspan="2"><p style="text-align: left; margin:0px;">: <?php echo $row['name']; ?> </p></td>
						<td rowspan="4"><img src="cropimg/<?php echo $row['photo']; ?>" align="right" width="100px" height="100px"></td>
					</tr>
					<tr>
						<th>3 . Date of birth</th>
						<td colspan="2">: <?php echo $dob; ?></td>
					</tr>
					<tr>
						<th>4 . Blood Group </th>
						<td colspan="2">: <?php echo $row['bg']; ?></td>
					</tr>
					<tr>
						<th>5 . Applied For</th>
						<td colspan="2">: <?php echo $row['applied']; ?></td>
					</tr>
					<tr>
						<th>6 . Gender</th>
						<td colspan="2">: <?php echo $row['gender']; ?></td>
					</tr>
					<tr>
						<th>7 . Community,Religion,Nationality,   </th>
						<td colspan="2">: <?php echo $religion; ?></td>
					</tr>
					<tr>
						<th>8 . Name of the father</th>
						<td colspan="2">: <?php echo $row['fname']; ?></td>
					</tr>
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Qualification</th>
						<td colspan="2">: <?php echo $row['fquali']; ?></td>
					</tr>
					
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Occupation</th>
						<td colspan="2">: <?php echo $row['focc']; ?></td>
					</tr>
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Annual income</th>
						<td colspan="2">: <?php echo $row['fincome']; ?></td>
					</tr>
					<tr>
						<th>9 . Name of the mother</th>
						<td colspan="2">: <?php echo $row['mname']; ?></td>
					</tr>
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Qualification</th>
						<td colspan="2">: <?php echo $row['mquali']; ?></td>
					</tr>
					
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Occupation</th>
						<td colspan="2">: <?php echo $row['mocc']; ?></td>
					</tr>
					<tr>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;Annual Income</th>
						<td colspan="2">: <?php echo $row['mincome']; ?></td>
					</tr>
					<tr>
						<th>10 . Contact No</th>
						<td colspan="2">: <?php echo $row['contact']; ?></td>
					</tr>
					<tr>
						<th>11 . Email</th>
						<td colspan="2">: <?php echo $row['email']; ?></td>
					</tr>
					<tr>
						<th>12 . Residential Address</th>
						<td colspan="2">: <?php echo $row['address']; ?></td>
					</tr>
					
					<br>
					
					<tr>
						<th colspan="2">13 . Name of the sister/brother (Siblings) studying in ST.JOSEPH OF CLUNY MAT. HR. SEC. SCHOOL</th>
						
					</tr>
					<table style="width:100%" border = "1" cellpadding = "5" cellspacing = "5">
							<tr>
								<th>Admission No</th>
								<th>Name of student</th>
								<th>Std & Sec</th>
														
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
				</table>
				
					</div>
				</div>
			</div>
			<br><br><br>
			<br>
			<div class="row">
				<div class="col-xs-12">	
					<div class="col-xs-6">
						<h6>Place : </h6><br>
						<h6>Date :</h6>
					</div>
					<div class="col-xs-6">
						<h6 style="text-align:right">Parent Signature</h6>
					</div>
				</div>
			</div>	
		</div>
				

</div>


