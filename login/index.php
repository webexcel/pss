
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Login</title>

<script src="https://www.google.com/recaptcha/api.js"></script>

<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="libs/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link href="libs/css/style.css" rel="stylesheet" type="text/css" media="screen">

</head>

<body style="background-image:url(images/login.png); background-repeat:no-repeat; background-size: 100% 100%;">
    <?php 
	session_start();
	session_destroy(); 
	?>
<div class="signin-form">
	<div class="container omb_login">
		<form class="form-signin" method="post" id="login-form" name="login-form" action="login-process.php" onsubmit="return validateForm()" enctype="multipart/form-data">
			<h2 class="form-signin-heading" style="color:#004071">Admin Login<img src="images/admin_pic.png" alt="Admin" name="Admin"></h2>
			<hr />
        	<div id="error">
				<!-- error will be shown here ! -->
			</div>
        	<div id="login1" style="display:block;">
			<div class="form-group">
				<label for="emailid">Username</label>
				<input type="text" class="form-control" placeholder="Username" name="username" id="username" />
				<span id="check-e"></span>
			</div>
        
			<div class="form-group">
				<label for="password">Password : </label>
				<input type="password" class="form-control" placeholder="Password" name="password" id="password" />
			</div>
       		</div>
			<div class="form-group">
				<div class="g-recaptcha" data-sitekey="6Lczsq4dAAAAABPPWvz9mGWT4gzalm94CObciJKW"></div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info" name="btn-login" id="btn-login" onClick="validateForm()">
					<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
				</button> 
			</div>
            <a href="../../index.php" style="color:#FFFFFF;">Back To Home</a>
      </form>

    </div>
    
</div>


<script type="text/javascript" src="libs/jquery/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="libs/jquery/validation.min.js"></script>
<script src="libs/bootstrap/js/bootstrap.min.js"></script>


<script type="text/javascript">
function validateForm() {
    var x = document.forms["login-form"]["username"].value;
	var y = document.forms["login-form"]["password"].value;
    if (x == "") {
        alert("Please Enter the Name");
		username.focus();
		username.select();
        return false;
    }
	 if (y == "") {
        alert("Please Enter the Password");
		password.focus();
		password.select();
        return false;
    }
}

</script>


</body>
</html>