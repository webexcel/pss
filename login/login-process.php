 <?php
$dbconnect =new  mysqli('localhost','root','P@mani4u','pss_website'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}
session_start();	
    if (isset($_POST['btn-login']))
    {     
			
		$yoursecret='6Lczsq4dAAAAAPSBZJWNxv0BIFZNxyab3Ec3EqqT';
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$yoursecret."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$googleobj = json_decode($response);
		$verified = $googleobj->success;
		if($verified === true)
		{
	
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$query = "SELECT * FROM login WHERE username='".$username."' and password='".$password."'";
			$resultdata = $dbconnect->query($query);
			if ($resultdata->num_rows > 0)
			{				
				$_SESSION['login_user'] = $username; 
				$_SESSION['loginid'] = rand(000,999999);
				header("location:gallery.php");
				exit();  
			}
			else
			{				 
				echo "<script type='text/javascript'>alert('Please enter valid User Name Or Password!')</script>";
			}
		}
		else
		{
			header("location:index.php");
			exit();
		}
	}
	
?>