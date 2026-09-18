<?php
/*$dbconnect =new  mysqli('localhost','root','P@mani4u','pss');
$rs=mysqli_query($dbconnect,"SELECT * FROM  `category` ORDER BY CatID DESC") or die(mysql_error());*/

// Builds a web usable path (folders/files may contain spaces)
function pss_gallery_url($path) {
	$parts = explode('/', $path);
	foreach ($parts as $key => $part) {
		$parts[$key] = rawurlencode($part);
	}
	return implode('/', $parts);
}

// All the photos of an album folder, in natural order (1,2,10 - not 1,10,2)
function pss_gallery_folder($folder) {
	$images = array();
	if (is_dir($folder)) {
		$files = scandir($folder);
		natcasesort($files);
		foreach ($files as $file) {
			if (preg_match('/\.(jpe?g|png|gif|webp)$/i', $file)) {
				$images[] = pss_gallery_url($folder . '/' . $file);
			}
		}
	}
	return array_values($images);
}

// The Annual Day 2021-22 photos live together with other years in one folder,
// so that album is listed file by file (same photos as annual-day.php)
function pss_gallery_files($folder, $files) {
	$images = array();
	foreach ($files as $file) {
		if (file_exists($folder . '/' . $file)) {
			$images[] = pss_gallery_url($folder . '/' . $file);
		}
	}
	return $images;
}

$pss_galleries = array(
	'annualday21' => array(
		'title'  => 'Annual Day 2021-22',
		'images' => pss_gallery_files('img/activity/annual day', array(
			'13.jpg', '15.jpg', '12.jpg', '7.jpg', '9.jpg', '3.jpg',
			'2.jpg', 'img30.jpeg', '11.jpg', '22.jpg', '33.jpg'
		))
	),
	'kgday' => array(
		'title'  => 'KG Programmes',
		'images' => pss_gallery_folder('gallery/kgday')
	),
	'PCShekar' => array(
		'title'  => 'P.C.Shekar Cricket Tournament',
		'images' => pss_gallery_folder('gallery/PCShekar')
	),
	'sportsday' => array(
		'title'  => 'Sports Day',
		'images' => pss_gallery_folder('gallery/sportsday')
	),
	'annualday' => array(
		'title'  => 'Annual Day 2019',
		'images' => pss_gallery_folder('gallery/annualday')
	),
	'primaryday' => array(
		'title'  => 'Primary Day',
		'images' => pss_gallery_folder('gallery/primaryday')
	)
);

// When a category is chosen its photos are shown as a grid on this same page.
// Without a valid category the page lists the categories, exactly as before.
$pss_album_key = isset($_GET['album']) ? $_GET['album'] : '';
$pss_album = isset($pss_galleries[$pss_album_key]) ? $pss_galleries[$pss_album_key] : null;
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


	<script type="text/javascript" src="wp-content\themes\genesis\js\jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="lib\jquery.mousewheel.pack.js?v=3.1.3"></script>

<!-- Gallery photo viewer -->
<link rel="stylesheet" type="text/css" href="wp-content/themes/genesis/css/gallery-lightbox.css">
<script type="text/javascript">
	var pssGalleries = <?php echo json_encode($pss_galleries); ?>;
</script>
<script type="text/javascript" src="wp-content/themes/genesis/js/gallery-lightbox.js"></script>
<style type="text/css">
	.gallery{
		border:5px solid #395c97;
		padding:2px;
	}
	.gallery1 a{
		cursor:pointer;
	}
	/* Thumbnail grid shown after a category is opened. Equal sized boxes keep
	   the rows tidy, and contain shows each photo whole (nothing is cropped). */
	[data-gallery-group] .gallery{
		width:100%;
		height:170px;
		object-fit:contain;
		background:#f7f7f7;
	}
	.pss-album-heading{
		margin-top:0;
		font-weight:bold;
	}
	.pss-album-back{
		display:inline-block;
		color:#395c97;
		font-weight:bold;
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
<?php if ($pss_album): ?>
							<!-- All the photos of the chosen category. A photo opens the viewer. -->
							<div class="row">
								<div class="col-xs-12">
									<h5 class="pss-album-heading"><?php echo htmlspecialchars($pss_album['title'], ENT_QUOTES); ?></h5>
									<p><a class="pss-album-back" href="gallery.php">&laquo; Back to Gallery</a></p>
								</div>
							</div>
							<div class="row" data-gallery-group="album" data-gallery-title="<?php echo htmlspecialchars($pss_album['title'], ENT_QUOTES); ?>">
<?php foreach ($pss_album['images'] as $pss_photo): ?>
								<div class="col-xs-6 col-sm-4 col-md-3">
									<p class="gallery1">
										<img class="gallery img-responsive" src="<?php echo $pss_photo; ?>" alt="<?php echo htmlspecialchars($pss_album['title'], ENT_QUOTES); ?>">
									</p>
								</div>
<?php endforeach; ?>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<p><a class="pss-album-back" href="gallery.php">&laquo; Back to Gallery</a></p>
								</div>
							</div>
<?php else: ?>
							<div class="row">
							   <div class="col-xs-6 col-sm-4 col-md-3">
								<h5>Annual Day 2021-22</h5>
								<p class="gallery1">
									<a id="annualday21" href="gallery.php?album=annualday21">
									<img class="gallery img-responsive" src="img/activity/annual day/13.jpg" alt=""></a>
								</p>
								</div>
								<div class="col-xs-6 col-sm-4 col-md-3">

								<h5>KG Programmes</h5>
								<p class="gallery1">
									<a id="kgday" href="gallery.php?album=kgday">
									<img class="gallery img-responsive" src="gallery/kgday/kg1.jpg" alt=""></a>
								</p>
								</div>
							    <div class="col-xs-6 col-sm-4 col-md-3">
								<h5>P.C.Shekar Cricket Tournament</h5>
								<p class="gallery1">
									<a id="PCShekar" href="gallery.php?album=PCShekar">
									<img class="gallery img-responsive" src="gallery/PCShekar/pc1.jpg" alt=""></a>
								</p>
								</div>
								<div class="col-xs-6 col-sm-4 col-md-3">

								<h5>Sports Day </h5>
								<p class="gallery1">
									<a id="sportsday" href="gallery.php?album=sportsday">
									<img class="gallery img-responsive" src="gallery/sportsday/sd1.jpg" alt=""></a>
								</p>
								</div>
								<div class="col-xs-6 col-sm-4 col-md-3">
								<h5>Annual Day 2019</h5>
								<p class="gallery1">
									<a id="annualday" href="gallery.php?album=annualday">
									<img class="gallery img-responsive" src="gallery/annualday/SS1_1.jpg" alt=""></a>
								</p>
								</div>
								<div class="col-xs-6 col-sm-4 col-md-3">
								<h5>Primary Day</h5>
								<p class="gallery1">
									<a id="primaryday" href="gallery.php?album=primaryday">
									<img class="gallery img-responsive" src="gallery/primaryday/pri1.jpg" alt=""></a>
								</p>
								</div>

						</div>
						<div class="row">

						</div>
<?php endif; ?>
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
<script type="text/javascript" src="wp-content\themes\genesis\js\jquery.mCustomScrollbar.concat.min.js"></script>

	<!-- end -->

</body>
</html>
