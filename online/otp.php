<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="style.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>


<body>
<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
		
            <span class="logo_title mt-5"> OTP </span>
        </div>
        <div class="card-body">
		<div>
			<span style="color:white;">You will recieve an OTP through SMS shortly</span>
		</div>
		
				<?php
					if( isset($_GET['valid']) && $_GET['valid'] != "" ) {
						echo " <div><span style='color:red; font-size:16px;'><b> Please Enter Valid OTP</b></span></div>";
					}
					else{
						echo "<div><span style='color:#red;'> Enter OTP</span></div>";
					}
				?>
            <form action="verify-otp.php" method="post">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="otp" class="form-control" placeholder="Otp" required/>
					<input type="hidden" name="pid" value="<?php echo $_GET['pid'] ?>" class="form-control">
					<input type="hidden" name="Year_Id" value="<?php echo $_GET['Year_Id'] ?>" class="form-control">
                </div>
				<div class="form-group">
                    <a href="index.php" class="btn btn-outline-danger float-left login_btn">Back</a>
                </div>				
                <div class="form-group">
                    <input type="submit" name="btn" value="Submit" class="btn btn-outline-danger float-right login_btn">
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>