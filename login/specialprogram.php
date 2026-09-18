<?php
session_start();
if($_SESSION['loginid'] && $_SESSION['login_user']){ ?>

<?php 

$dbconnect = new  mysqli('localhost','root','P@mani4u','pss_website');
if(isset($_POST['btn_action'])){
   extract($_POST);		
	if(isset($_POST['btn_action']))
	{
		$query= "insert into special_program (`title`, `description`) values ('".$title."','".$dis."')";
		if(mysqli_query($dbconnect,$query))
		{
			$data['code']=1;
			$data['msg']="Success";
				
		}else
		{
			$data['code']=2;
			$data['msg']="failed";
		}
	}else
	{
			$data['code']=2;
			$data['msg']="Upload failed";
	}
	$_SESSION['datavalue'] = $data;
	header('Location: '.$_SERVER['PHP_SELF']);		
}



if(isset($_POST['deletenews'])){
	$query= "delete from special_program where id = ".$_POST['hiddencat'];
	if(mysqli_query($dbconnect,$query)){
		$data['code']=1;
		$data['msg']="Deleted Successfully";
	}else{
		$data['code']=2;
		$data['msg']="Deleted failed";
	}
	$_SESSION['datavalue'] = $data;
	header('Location: '.$_SERVER['PHP_SELF']);
	
}
$rs=mysqli_query($dbconnect,"SELECT * FROM  `special_program` ORDER BY id DESC") or die(mysql_error());


?>


<!doctype html>
<html class="no-js" lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="robots" content="">
<meta name="author" content="">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\bootstrap.css">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\bootstrap.css.css">
<link rel="stylesheet" type="text/css" media="all" href="wp-content\themes\genesis\style.css">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\swiper.css">
<link rel="stylesheet" href="wp-content\themes\genesis\css\jquery.mCustomScrollbar.css">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\genesis-content-bottom-inner-pages-links.css">
<link rel='stylesheet' id='font-awesome-css' href='wp-content\themes\genesis\css\font-awesome.min.css' type='text/css' media='all'>
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\style.css">

<body class="home blog">

<!-- Wrapper -->
<div class="wrapper">
	<?php include("header.php"); ?>
		<!-- About Round Square Section -->
    <div class="container-fluid about_container ">
        <div class="row">
            <div class="container-fluid">
                <div class="container multipurpose_hall container  multipurpose_hall admission_container">
				  	<div class="col-xs-12 col-sm-11 col-md-11 col-md-offset-1">
                        <h1><span class="h3_trigger ggs_about_team" id="6">Add BMW</span></h1>
					</div>
				 </div>
		<div class="container about_slider_bg   academics_the_curriculum  residential_school_content   container-fluid container-fluid break-genesis">
 <style>
.btn{
	color:#fff;
	background-color:#f4801d;
}
</style>                 

			<div class="container">
				<!-- Contant -->
					<div class="col-md-12">

						<form method="post" action="" enctype="multipart/form-data"><br />
						<!--<div class="row">
							<div class="form-group">
								<div class="col-sm-4">
									<input type="text" name="title" id="title" placeholder="Enter Title">
								</div>
							</div>
						</div>
						<br>-->
						<div class="row">						
							<div class="form-group">
								<div class="col-sm-4">
									<textarea class="form-control" id="title" name="title" rows="5" placeholder="Enter Title"></textarea>
								</div>
							</div>
						</div>
						<br>
						<div class="row">						
							<div class="form-group">
								<div class="col-sm-4">
									<textarea class="form-control" id="dis" name="dis" rows="5" placeholder="Enter Description"></textarea>
								</div>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-4">
									<input type="submit" id="btn_action" class="btn primary" name="btn_action" Value="Save">
								</div>
							</div>
						</div>	
						</form>
						
					</div>
				<!-- Contant -->

				<div class="col-md-12">
					<div class="blog-detail-holder">
						<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="txt-center">S.No</th>
                                    <th width="40%" class="text-left">Title</th>
									<th width="40%" class="text-left">Description</th>
									<th width="5%" class="txt-center">Edit</th>
                                    <th width="5%" class="txt-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
									$countcatrow = 1;
                                    while($row = mysqli_fetch_assoc($rs)){  
                               ?>          
							    <tr>
									<td class="txt-center"><?php echo $countcatrow; ?></td>
									<td><?php echo $row['title']; ?></td>
									<td><?php echo $row['description']; ?></td>
									<td class="txt-center">
									   <a href="spedit.php?newsid=<?php echo $row['id']; ?>">edit</a>
									</td>
									<td class="txt-center">
									   <a class="catgoryclick" cid="<?php echo $row['id'] ?>">delete</a>
									</td>
								</tr>
                                <?php $countcatrow = $countcatrow +1; } ?>
                	        </tbody>
						</table>
					</div>
				</div>
			</div>
			
			
				</div>	
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php include("../footer.php"); ?>
	<!-- Footer -->

</div>
<!-- Wrapper -->
 <!----- delete model box----->               
<button type="hidden" data-toggle="modal" data-target="#exampleModal"></button>  
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p>Do You Want Delete This Item</p>
		
      </div>
      <div class="modal-footer">
     <input type="hidden" value="" name="hiddencat" id="hiddencat">
             <button type="submit" name="deletenews" class="btn btn-success" style="width:30%">Yes</button>
             <button class="btn btn-danger" style="width:30%">No</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript" src="wp-content\themes\genesis\js\jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\jquery.navgoco.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\bootstrap.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\jquery.pickmeup.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\demo.js" async=""></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\custom.js"></script>
<script src="wp-content\themes\genesis\inc\genesis-framework\admission-form\multi_step_form.js"></script>
<script src="wp-content\themes\genesis\js\classie.js"></script>
<script src="wp-content\themes\genesis\js\selectFx.js"></script>
<script src="wp-content\themes\genesis\js\jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Template Custom JavaScript File -->

<script type="text/javascript">
	$(document).ready(function() {
        $(".catgoryclick").click(function(){
			$("#exampleModal").modal('show');
			var currentcatval = $(this).attr('cid');
			$("#hiddencat").val(currentcatval);
		});
    });
	
	$(document).ready(function() {
        $(".catgoryclick1").click(function(){
			$("#exampleModal1").modal('show');			
			var currentcatval1 = $(this).attr('newsid');
			$("#hiddencat1").val(currentcatval1);
			/*$.ajax({
				  url: "news.php",
				  type: "get",
				  data: { 
					newsid: currentcatval1
				  },
				  success: function(response) {
				  },
				  error: function(xhr) {
				  }
				});*/
			
		});
    });
	
	$(window).scroll(function() {
	  if ($(document).scrollTop() > 50) {
		$('nav').addClass('shrink');
	  } else {
		$('nav').removeClass('shrink');
	  }
	});
</script>
<script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>

</body>
</html>
<?php 
}
else
{
	header("location:index.php");
}
?>