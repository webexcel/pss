<?php
session_start();
if($_SESSION['loginid'] && $_SESSION['login_user']){ ?>

<?php 

$dbconnect =new  mysqli('localhost','root','P@mani4u','pss_website');

if(isset($_POST['submit_value_cat']) || isset($_POST['submit_value'])){
	extract($_POST);

	if(isset($_POST['submit_value_cat'])){
		$query= "insert into category (CatName,AddDate) values ('".$category_name."','".date('Y-m-d')."')";
		if(mysqli_query($dbconnect,$query)){
			$data['code']=1;
			$data['msg']="Success";
		}else{
			$data['code']=2;
			$data['msg']="failed";
		}
	}
	else if(isset($_POST['submit_value']))
	{  
		for($i=0; $i < count($_FILES['gallery_name']['name']); $i++)
		{
			$filenewpath = 'gallery/'.$_FILES['gallery_name']['name'][$i];
			//echo $filenewpath = '\upload\\gallery\\'.$_FILES['gallery_name']['name'][$i];
			//exit;
			$filepath = 'login/gallery/'.$_FILES['gallery_name']['name'][$i];
			
			move_uploaded_file($_FILES['gallery_name']['tmp_name'][$i], $filenewpath);
			$query = "insert into gallery (GalCatID,GalPath,GalUplDate) values ('".$category_type."','".$filepath."','".date('Y-m-d')."')";
			$Gallery = mysqli_query($dbconnect,$query);
		}
	}
	//$_SESSION['datavalue'] = $data;
	header('Location: '.$_SERVER['PHP_SELF']);	
}
if(isset($_POST['deletecategory'])){
	$query= "delete from category where CatID = ".$_POST['hiddencat'];
	if(mysqli_query($dbconnect,$query)){
		$data['code']=1;
		$data['msg']="Deleted Successfully";
	}else{
		$data['code']=2;
		$data['msg']="Deleted failed";
	}
	//$_SESSION['datavalue'] = $data;
	header('Location: '.$_SERVER['PHP_SELF']);
	//header("Location: " . "http://" . $_SERVER['HTTP_HOST'].'gallery.php');
}


$rs=mysqli_query($dbconnect,"SELECT * FROM  `category` ORDER BY CatID DESC") or die(mysql_error());
$rstable=mysqli_query($dbconnect,"SELECT * FROM  `category` ORDER BY CatID DESC") or die(mysql_error());

?>


<!doctype html>
<html class="no-js" lang="en">

<head>
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
</head>

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
                        <h1><span class="h3_trigger ggs_about_team" id="6">Add Gallery</span></h1>
					</div>
				 </div>
				<div class="container about_slider_bg   academics_the_curriculum  residential_school_content   container-fluid container-fluid break-genesis">
                  
<style>
.btn{
	color:#fff;
	background-color:#ae1f6e;
}
</style>
				<div class="container">
					<!-- Contant -->
					<div class="col-md-12">
					<p><?php echo (isset($_session['datavalue']))? $_session['datavalue']:""; ?></p>
						<form method="post" action="" enctype="multipart/form-data" onClick="return validate();">
								<div class="col-sm-3">
									<label>ADD Category</label>
									<div class="category_div">
										<input type="text" name="category_name" id="category_name" placeholder="Enter Category Name">
									</div>
								  <br>
								   <input type="submit" class="btn" name="submit_value_cat" value="Save">  
								</div> 
								
								<div class="col-sm-2">
								</div>
								
								<div class="col-sm-3">
									<label>Category List</label>
									<div class="gallery_div" style="display: block;">
										<select name="category_type" id="category_type">
											<?php while($rows = mysqli_fetch_assoc($rs)){
											echo '<option value="'.$rows['CatID'].'">'.$rows['CatName'].'</option>';
											}?>
										</select>
									</div>
									<br>
									<input type="file" name="gallery_name[]" id="gallery_name" multiple=true>
									<br>
									<p style="color:#FF0000;"><strong>Note:</strong>
										 Image file size below:100kb<br>
										 Image Pixcel size:600px X 450px </p>
									<input type="submit" name="submit_value" class="btn primary" value="submit">
								</div>    							  
						</form>					
					</div>
					<!-- Contant -->
		
					<div class="col-md-12">
						<table class="table table-bordered">
								<thead>
									<tr>
										<th width="6%" class="txt-center">S.No</th>
										<th width="74%">Category Name</th>
										<th width="10%" class="txt-center">Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$countcatrow = 1;
									while($row = mysqli_fetch_assoc($rstable)){  ?>
									<tr>
										<td class="txt-center"><?php echo $countcatrow; ?></td>
										<td> <?php echo $row['CatName']; ?> </td>
										<td class="txt-center"><a class="catgoryclick" catid="<?php echo $row['CatID'] ?>"><input type="button" 
										class="btn primary" value="delete"></a></td>
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
	<!-- Footer -->
	<?php include("../footer.php"); ?>
	<!-- Footer -->

</div>
<!-- Wrapper -->
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
             <button type="submit" name="deletecategory" class="btn btn-success" style="width:30%">Yes</button>
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
	$("#upload_type").on('change',function(){
		if(this.value==2){
			$(".gallery_div").show();
			$(".category_div").show();
		}else{
			$(".category_div").show();
			$(".gallery_div").show();
		}
	});
	$(document).ready(function() {
        $(".catgoryclick").click(function(){
			$("#exampleModal").modal('show');
			//$(".bd-example-modal-sm").modal('show');
			var currentcatval = $(this).attr('catid');
			$("#hiddencat").val(currentcatval);
		});
    });
</script>	
	
<script type="text/javascript">
	function validate(){
		var size=1097;
		var file_size=document.getElementById('file_upload').files[0].size;
			if(file_size>=size){
				alert('File too large');
				return false;
			}
	}
</script>

<script type="text/javascript">
	$(window).scroll(function() {
	  if ($(document).scrollTop() > 50) {
		$('nav').addClass('shrink');
	  } else {
		$('nav').removeClass('shrink');
	  }
	});
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