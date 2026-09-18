<?php 
$dbconnect =new  mysqli('localhost','root','P@mani4u','pss_website');
$rs=mysqli_query($dbconnect,"SELECT * FROM  `category` ORDER BY CatID DESC") or die(mysql_error());
?>

<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
<meta charset="UTF-8">
<title>PS Senior Secondary School - Milestones </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\bootstrap.css">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\bootstrap.css.css">
<link rel="stylesheet" type="text/css" media="all" href="wp-content\themes\genesis\style.css">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\swiper.css">
<link rel="stylesheet" href="wp-content\themes\genesis\css\jquery.mCustomScrollbar.css">
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\genesis-content-bottom-inner-pages-links.css">
<link rel='stylesheet' id='font-awesome-css' href='wp-content\themes\genesis\css\font-awesome.min.css' type='text/css' media='all'>
<link type="text/css" rel="stylesheet" href="wp-content\themes\genesis\css\style.css">


<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="lib\jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="lib\jquery.mousewheel.pack.js?v=3.1.3"></script>
	
	<script type="text/javascript" src="source\jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="source\jquery.fancybox.css?v=2.1.5" media="screen">
	<link rel="stylesheet" type="text/css" href="source\helpers\jquery.fancybox-buttons.css?v=1.0.5">
	<script type="text/javascript" src="source\helpers\jquery.fancybox-buttons.js?v=1.0.5"></script>
	<link rel="stylesheet" type="text/css" href="source\helpers\jquery.fancybox-thumbs.css?v=1.0.7">
	<script type="text/javascript" src="source\helpers\jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript" src="source\helpers\jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript" src="lib\gallery.js"></script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>	
	
<body class="home blog">
    <!-- header Section -->
		<?php include("header.php"); ?> 
        
		
    <!-- end header -->

    <!-- About Round Square Section -->
    <div class="container-fluid about_container ">
        <div class="row">
            <div class="container-fluid">
                <div class="container multipurpose_hall container  multipurpose_hall admission_container">
				  	<div class="col-xs-12 col-sm-11 col-md-11 col-md-offset-1">
                       
					<!--<h2 class="h3_trigger ggs_about_team" id="6">why-genesis</h2>-->
                        <h1><span class="h3_trigger ggs_about_team" id="6">Gallery</span></h1>
					</div>
				</div>			  				   					
				<div class="container">
					<div class="col-xs-12">
						<div class="course-detail">
							<?php while($row = mysqli_fetch_assoc($rs)){
								$firstgallery=mysqli_query($dbconnect,"select * from gallery where GalCatID = ".$row['CatID']) or die(mysql_error());
								$galleryrow = mysqli_fetch_assoc($firstgallery);
								echo '<div class="col-md-3">
										<h5 style="margin:5px 0 5px;"><b>'.$row['CatName'].'</b></h5>
										<a id="art-exibition" href="javascript:;"  catid="'.$row['CatID'].'"  class="gallery_grid">'; 
								if(!$galleryrow){
									echo '<img class="gallery img-responsive" style="width:100%!important;" src="images/default/default-image.jpg" alt="">';
								}else{
									echo '<img class="gallery" style="width:250px!important;height:200px!important; border:5px solid #395c97; padding:2px;" src="http://pssenior.edu.in/'.$galleryrow['GalPath'].'" alt="">';
								}
								echo '</a></div>';
								}
							?>
						</div>		
					</div>
					
				</div> 
				</div>
			</div>
		</div>
    </div>
    
    <!-- END About Round Square -->


<!-- SETUP DATA END -->
<!-- Footer Section -->

  <?php include("footer.php"); ?>

<!-- include javascript -->

<script type="text/javascript" src="wp-content\themes\genesis\js\jquery.navgoco.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\bootstrap.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\jquery.pickmeup.js"></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\demo.js" async=""></script>
<script type="text/javascript" src="wp-content\themes\genesis\js\custom.js"></script>

	<!-- end -->

</body>
</html>
