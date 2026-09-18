<?php
session_start();
if($_SESSION['loginid'] && $_SESSION['login_user']){ ?>

<?php 

$dbconnect = new  mysqli('localhost','root','P@mani4u','pss_website');

$newsid = $_GET['newsid'];

$qry = "SELECT * FROM  `news` where nid = '".$newsid."'";
$rq = mysqli_query($dbconnect,$qry) or die(mysql_error());
$rows = mysqli_fetch_assoc($rq);
$pevent = $rows['past_event'];
$levent = $rows['latest_event'];
$edate = $rows['eventDate'];

if(isset($_POST['btn_action']))
	{
	$pevent1 = $_POST['pevent1'];
	$levent1 = $_POST['levent1'];
	$eventDate1 = $_POST['eventDate1'];
	$query= "UPDATE `news` SET `past_event`= '".$pevent1."',`latest_event` = '".$levent1."',`eventDate` = '".$eventDate1."'  WHERE `nid`= $newsid";
	
		if(mysqli_query($dbconnect,$query))
		{
			$data['code']=1;
			$data['msg']="Success";
			header('Location: news.php');
		}else
		{
			$data['code']=2;
			$data['msg']="failed";
		}
  }

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
                        <h1><span class="h3_trigger ggs_about_team" id="6">Add News and Events</span></h1>
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
						<div class="row">						
							<div class="form-group">
								<div class="col-sm-4">
									<textarea class="form-control" id="pevent1" name="pevent1" rows="5" placeholder="Enter Past events"><?php echo $pevent; ?></textarea><br>
										
								</div>
							</div>
						</div>
						<br>
						<div class="row">						
							<div class="form-group">
								<div class="col-sm-4">
									<textarea class="form-control" id="levent1" name="levent1" rows="5" placeholder="Enter Latest events"><?php echo $levent; ?></textarea><br>
										
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-4">
									<input type="date" name="eventDate1" id="eventDate1" value="<?php echo $edate; ?>">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-4">
									<input type="submit" id="btn_action" class="btn primary" name="btn_action" Value="Save News and Events">
								</div>
							</div>
						</div>	
						</form>
						
					</div>
				<!-- Contant -->

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