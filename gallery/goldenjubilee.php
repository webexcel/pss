<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
<meta charset="UTF-8">
<title>PS Senior Secondary School - Milestones</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link type="text/css" rel="stylesheet" href="wp-content/themes/genesis/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="wp-content/themes/genesis/css/bootstrap.css.css">
<link rel="stylesheet" type="text/css" media="all" href="wp-content/themes/genesis/style.css">
<link type="text/css" rel="stylesheet" href="wp-content/themes/genesis/css/swiper.css">
<link rel="stylesheet" href="wp-content/themes/genesis/css/jquery.mCustomScrollbar.css">
<link type="text/css" rel="stylesheet" href="wp-content/themes/genesis/genesis-content-bottom-inner-pages-links.css">
<link rel='stylesheet' id='font-awesome-css' href='wp-content/themes/genesis/css/font-awesome.min.css' type='text/css' media='all'>
<link type="text/css" rel="stylesheet" href="wp-content/themes/genesis/css/style.css">

<style>
/* ===== PAGE WRAPPER ===== */
body {
    background-color:#1c58b1;
}
.jubilee-page-wrapper {
    background:#ffffff;
    padding:30px 15px 50px;
    margin-top:20px;
    margin-bottom:20px;
    border-radius:6px;
}

/* ===== JUBILEE CARD (TOP SECTION) ===== */
.jubilee-card {
    background: linear-gradient(135deg, #ffffff, #fff6dd);
    border-radius: 18px;
    padding: 24px 28px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.18);
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
}

/* gold left accent bar */
.jubilee-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 6px;
    height: 100%;
    background: #d49c1f;
}

/* decorative circle */
.jubilee-card::after {
    content: "";
    position: absolute;
    right: -40px;
    bottom: -40px;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 8px solid rgba(212,156,31,0.18);
}

.jubilee-logo img {
    max-width: 100%;
    height: auto;
}

/* heading & text */
.jubilee-card h2 {
    font-size:22px;
    font-weight:700;
    color:#1c3b6b;
    margin-bottom:8px;
}
.jubilee-sub {
    font-size:14px;
    color:#444;
    margin-bottom:16px;
    line-height:1.5;
}

/* CTA button */
.jubilee-cta {
    display:inline-block;
    background:#1c58b1;
    color:#fff !important;
    padding:10px 22px;
    border-radius:30px;
    font-weight:700;
    font-size:14px;
    text-decoration:none !important;
    box-shadow:0 6px 14px rgba(0,0,0,0.22);
    transition:0.25s ease;
}
.jubilee-cta:hover {
    background:#143f7f;
    transform:translateY(-2px);
}

/* Small note under button */
.jubilee-note {
    font-size:12px;
    color:#777;
    margin-top:8px;
}

/* ===== PODCAST LIST ===== */

/* Mobile – 1 column by default */
.podcast-list {
    display: grid;
    gap: 20px;
    grid-template-columns: 1fr;
}

/* Tablet + laptop + desktop – 2 columns max */
@media (min-width: 768px) {
    .podcast-list {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

/* Podcast cards */
.podcast-card2 {
    padding: 18px;
    border-radius: 14px;
    display: flex;
    gap: 14px;
    align-items: flex-start;
    color: #ffffff;
    box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    transition: transform .25s ease, box-shadow .25s ease;
}

/* Vibrant background colors */
.podcast-card2:nth-child(1)  { background: #ff6b6b; }
.podcast-card2:nth-child(2)  { background: #ff9f43; }
.podcast-card2:nth-child(3)  { background: #1dd1a1; }
.podcast-card2:nth-child(4)  { background: #54a0ff; }
.podcast-card2:nth-child(5)  { background: #5f27cd; }
.podcast-card2:nth-child(6)  { background: #10ac84; }
.podcast-card2:nth-child(7)  { background: #ee5253; }
.podcast-card2:nth-child(8)  { background: #f368e0; }
.podcast-card2:nth-child(9)  { background: #ff6b6b; }
.podcast-card2:nth-child(10) { background: #ff9f43; }
.podcast-card2:nth-child(11) { background: #1dd1a1; }
.podcast-card2:nth-child(12) { background: #54a0ff; }
.podcast-card2:nth-child(13) { background: #5f27cd; }

.podcast-card2:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.25);
}

/* Photo */
.podcast-photo {
    width: 70px;
    height: 70px;
    border-radius: 10px;
    background:#ffffff33;
    background-size: cover;
    background-position: center;
    flex-shrink: 0;
    border: 2px solid #ffffff;
}

/* Podcast text */
.podcast-card2 h3 {
    font-size: 18px;
    font-weight: 700;
    color:#fff;
    margin:0 0 4px 0;
}
.podcast-card2 p {
    font-size: 14px;
    color:#f1f1f1;
    margin:0 0 8px 0;
}

/* Button */
.yt-btn {
    display: inline-block;
    background: #ffffff;
    color: #333 !important;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    transition: 0.2s;
}
.yt-btn:hover {
    transform: scale(1.08);
    background: #f0f0f0;
}

/* Make sure nothing hides this section on mobile */
@media (max-width: 767px) {
  .jubilee-page-wrapper {
      display:block !important;
      visibility:visible !important;
      overflow:visible !important;
  }
}
</style>
</head>

<body class="home blog">

<?php include("header.php"); ?>

<div class="container-fluid about_container">
  <div class="row">
    <div class="container-fluid">
      <div class="container jubilee-page-wrapper">

        <!-- TOP: JUBILEE CARD (logo + message) -->
        <div class="row jubilee-top">
    
    <!-- LEFT FIXED COLUMN -->
    <div class="col-xs-12 col-md-4 left-jubilee">
        <div class="jubilee-card">  <h2>Celebrating 50 years of memories, milestones, and making a difference!</h2>
            <div class="jubilee-logo">
                <img src="img/PssLogo.jpg" alt="PS School Logo">
            </div>

          

            <p class="jubilee-sub">We are launching a special videocast series:<br/>
“So You Want To Become…”<br/>
In this series, alumni from across batches return to the campus to share their journeys, lessons and memories that shaped who they are today.<br/>
Episodes will premiere on the school’s official YouTube channel, LinkedIn page, and website.</p>

            <a href="https://forms.gle/wGAuLMLvGjt1jDH88"
               target="_blank"
               class="jubilee-cta">
               Fill the Alumni Registration Form
            </a>
        </div>
    </div>


       <div class="podcast-list">

    <!-- 1: Sri K. V. S. Gopalakrishnan -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a5.jpg');"></div>
        <div>
            <h3>Sri. K.V.S.Gopalakrishnan</h3>
            <br/> <a href="https://youtu.be/LQ4dNuxPjHM" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 2: Smt Vijayalakshmi Srivatsan -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a8.jpg');"></div>
        <div>
            <h3>Smt. Vijayalakshmi Srivatsan</h3>
            <br/> <a href="https://youtu.be/qhIqBHhyVG0" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 3: Sri P.C. Ramakrishna -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a4.jpg');"></div>
        <div>
            <h3>Sri. P.C.Ramakrishna</h3>
            <br/> <a href="https://youtu.be/DCtR5V1Z2uU" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 4: Smt Lakshmi Srinivasan -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a9.jpg');"></div>
        <div>
            <h3>Smt Lakshmi Srinivasan</h3>
            <br/> <a href="https://youtu.be/kKTVUbRkTX8" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 5: Sri P. S. Prabhakar (placeholder) -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/placeholder.jpg');"></div>
        <div>
            <h3>Sri. P. S. Prabhakar</h3>
            <br/> <a href="#" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 6: Prof. V. Kamakoti -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a7.jpg');"></div>
        <div>
            <h3>Prof. V. Kamakoti</h3>
            <br/> <a href="https://youtu.be/y8yQCPLwMM8" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 7: Smt. K Alamelu -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a13.jpg');"></div>
        <div>
            <h3>Smt. K Alamelu</h3>
            <br/> <a href="https://youtu.be/BlgfZgC6Exs" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 8: Kumari Spoorthi Rao -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a6.jpg');"></div>
        <div>
            <h3>Ms. Spoorthi Rao</h3>
            <br/> <a href="https://youtu.be/pzcZPxGJj2M" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- --- REMAINING CARDS (after your 8) --- -->

    <!-- 9: Sri Vidwan Saketharaman -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a1.jpg');"></div>
        <div>
            <h3>Sri. Vidwan Saketharaman</h3>
            <br/><a href="https://youtu.be/pwa-6O7xpcs" class="yt-btn" target="Blank">Watch on YouTube</a>
        </div>
    </div>

    <!-- 10: Col. Vembu Sankar -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a2.jpg');"></div>
        <div>
            <h3>Col. Vembu Sankar</h3>
            <br/><a href="https://youtu.be/JDtVEvO55Gs" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 11: Sri. Ishwar Achanta -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a3.jpg');"></div>
        <div>
            <h3>Sri. Ishwar Achanta</h3>
            <br/><a href="https://youtu.be/Cv7nk15CEDM" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 12: Sri. Ravishankar Gopalan -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a10.jpg');"></div>
        <div>
            <h3>Sri. Ravishankar Gopalan</h3>
            <br/> <a href="https://youtu.be/X6datebqBWk" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

    <!-- 13: Sri. Sudarsan Ranganathan -->
    <div class="podcast-card2">
        <div class="podcast-photo" style="background-image:url('img/alumni/a11.jpg');"></div>
        <div>
            <h3>Sri. Sudarsan Ranganathan</h3>
            <br/> <a href="https://youtu.be/aDRGDRtkXyw" class="yt-btn">Watch on YouTube</a>
        </div>
    </div>

   <style>
    .podcast-card2:last-child {
    margin-left: auto;
}
.podcast-card2:last-child {
    grid-column: span 2;
    width: 100%;
}

    
.card-white {
    background-color: #6C63FF;
}
</style>

<!-- 14: Dr. Ajit Pai -->
 <div class="podcast-list">
<div class="podcast-card2">
    <div class="podcast-photo" style="background-image:url('img/alumni/a12.jpg');"></div>
    <div>
        <h3>Dr. Ajit Pai</h3>
        <br/>
        <a href="https://youtu.be/o3QL5E2sN-k" class="yt-btn">Watch on YouTube</a>
    </div>
</div>



</div>
</div>

      </div>
    </div>
  </div>

<?php include("footer.php"); ?>

<script type="text/javascript" src="wp-content/themes/genesis/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="wp-content/themes/genesis/js/jquery.navgoco.js"></script>
<script type="text/javascript" src="wp-content/themes/genesis/js/bootstrap.js"></script>
<script type="text/javascript" src="wp-content/themes/genesis/js/jquery.pickmeup.js"></script>
<script type="text/javascript" src="wp-content/themes/genesis/js/demo.js"></script>
<script type="text/javascript" src="wp-content/themes/genesis/js/custom.js"></script>
<script src="wp-content/themes/genesis/inc/genesis-framework/admission-form/multi_step_form.js"></script>
<script src="wp-content/themes/genesis/js/classie.js"></script>
script src="wp-content/themes/genesis/js/selectFx.js"></script>
<script src="wp-content/themes/genesis/js/jquery.mCustomScrollbar.concat.min.js"></script>

</body>
</html>
