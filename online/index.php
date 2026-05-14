<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="style.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag --------
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">-->
</head>
<body>
<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span> <img src="images/logo.png" class="w-25" alt="Logo"> </span><br/>
                        <span class="logo_title mt-5"> P.S.Senior Secondary School</span>
        </div>
        <div class="card-body">
				<?php
						if( isset($_GET['valid']) && $_GET['valid'] != "" ) {
							echo " <div><span style='color:red; font-size:16px;'><b> The Admission Number is not Registered in the School.</b></span></div>";
						}
						else{
							echo "<div><span style='color:#fff;'> Enter Admission Number in the School.</span></div>";
						}
						if( isset($_GET['valid1']) == "1" ) {
							echo " <div><span style='color:red; font-size:16px;'><b>
							Fee defaulter for your ward.Kindly fees pay last acdemic year </b></span></div>";
						}
					?>
            <form action="send-otp.php" method="post">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                    </div>
                    <input type="text" name="mobile" class="form-control" placeholder="Admission No" required />
                </div>
				<div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class=" fa-user"></i></span>
                    </div>
					<select  class="form-control" id="yearid" name="yearid" required />
						<option value="">Select Academic Year</option>
						<!--<option value="3">2023-2024</option>-->
						<option value="4">2024-2025</option>
						<option value="5">2025-2026</option>
                        <option value="6">2026-2027</option>
					</select>
				 </div>
                <div class="form-group">
                    <input type="submit" name="btn" value="Login" class="btn btn-outline-danger float-right login_btn">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>