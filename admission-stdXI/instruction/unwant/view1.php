<?php 
session_start();
$dbconnect =new  mysqli('localhost','root','webexcel@123','muruga'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="cosmic">
		<meta name="keywords" content="murugadhanushkodi">

		<title>Application Form</title>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.bootstrap.min.css" type="text/css" />
  
<style>
.datatable tfoot {
  display: table-header-group;
}

.datatable tfoot .filter-column {
  width: 100% !important;
}
</style>

		<!------ Include the above in your HEAD tag ---------->

	</head>
	

<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="index.php" alt="home">Back</a>
				</div>
			</div>
			<div class="row">   						
				<table  class="datatable table table-hover table-bordered">
					<thead> 
						<tr>
							<th>Name</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody style="border-top:#585454;">	
					<?php 
					$result = mysqli_query($dbconnect,"SELECT concat(`group`) as name ,count(`group`) as total FROM `application_new` group by `group`");
					while($row 	= mysqli_fetch_assoc($result))
					{
						$name 	= $row['name'];
						$total  = $row['total'];
					?>
					
						<tr>
							<td> <?php
								if(empty($name))
								{
									echo 'Seats Avaliable';
								}else{
									echo $name;
								}
								 ?></td>		
							<td> <?php echo $total; ?> </td>
					    </tr>
					<?php  
					}
					?>				
					 </tbody>   
				</table>
			</div>
			
            <div class="row">   						
				<table  class="datatable table table-hover table-bordered">
					<thead> 
						<tr>
							<th>SNo</th>
							<th>Application No</th>
							<th>Name</th>
							<th>Dob</th>
							<th>Group</th>							
							<th>Download</th>	
						</tr>
					</thead>
					<tbody style="border-top:#585454;">	
						<?php 
						
						$countrow = 1;
						
						$result = mysqli_query($dbconnect,"select * from application_new where `status` = 1");
						while($row = mysqli_fetch_assoc($result))
						  {
							
							$id           = $row['id'];
							$name         = $row['name'];
							$originalDate = $row['dob'];
							$dob  		  = date("d-m-Y", strtotime($originalDate));
							$group        = $row['group'];
					
						   ?>
						   <tr>
								<td> <?php echo $countrow++; ?> </td>
								<td> <?php echo $id; ?> </td>		
								<td> <?php echo $name; ?> </td>
								<td> <?php echo $dob; ?> </td>
								<td> <?php echo $group; ?> </td>
							
								<td>
									<a target = "_blank" href="pdf.php?ids=<?php echo $id; ?>">Download</a>
								</td>
							</tr>
						<?php  
						}
						?> 
				
						 
					 </tbody>   
					</table>
				
        

			</div><!--/.row-->
        </div><!--/.container-->

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>	
	<script src="//cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
	
		<script type="text/javascript">
	
		var dataTable = $('.datatable').DataTable({
			  buttons: [
				{
				  extend: 'excel',
				  text: 'Export to Excel',
				  className: 'btn-sm btn-flat',
				},
			  ],
			  dom: "<'row'<'col-md-3'l><'col-md-6 text-center'B><'col-md-3'f>>" +
					 "<'row'<'col-md-12'tr>>" +
					 "<'row'<'col-md-5'i><'col-md-7'p>>",
			  drawCallback: function(settings) {
				if (!$('.datatable').parent().hasClass('table-responsive')) {
				  $('.datatable').wrap("<div class='table-responsive'></div>");
				}
			  }
			});

			dataTable.columns().every(function() {
			  var column = this;

			  $('.filter-column', this.footer()).on('keyup change', function() {
				if (column.search() !== this.value) {
				  column
					.search(this.value)
					.draw();
				  this.focus();
				}
			  });
			});
			
		</script>	
		<script type="text/javascript">		
			function showappid(rowid){								
				$("#exampleModal").modal('show');
				var catval = rowid;
				$("#hiddencat").val(catval);
				}							
		</script>
		
	</body>
</html>			