<?php
session_start();
include('config.php');
$con = dbconnect();
if (mysqli_connect_errno()){ echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

if(isset($_POST['register'])){

	$sql="SELECT * FROM users WHERE email='".$_POST['email']."'";
	if($result = mysqli_query($con,$sql)){
		if(mysqli_num_rows($result) < 1){
			$sql = "INSERT INTO users SET email = '".$_POST['email']."', password = '".md5($_POST['password'])."'";
			mysqli_query($con, $sql);
			$msg = "Successfully Registered.";
		}else{
			$msg = "Already Registered.";
		}

	}

}

if(isset($_POST['login'])){
	$query = "SELECT * FROM `users` WHERE email='".$_POST['email']."' and password='".md5($_POST['pwd'])."'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	if($rows==1){
		$_SESSION['appoint_email'] = $_POST['email'];
		header("Location: manage-data.php");
	}else{
		$msg = "Username/password is incorrect.";
	}
}
if(isset($_POST['reset_pwd'])){
	print_r($_POST);
}

?>
<!DOCTYPE HTML>
<html lang="zxx">
<head>
	<title>Appointment Dashboard Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="Effect Login Form Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements"
	/>
	<link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
	<link href="//fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
</head>
<body>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
<body>
	<!-- bg effect -->
	<div id="bg">
		<canvas></canvas>
		<canvas></canvas>
		<canvas></canvas>
	</div>
	<div class="sub-main-w3">
		<form method="post" style="margin-top:30px;">
		<?php if($_REQUEST['q'] == 'sign_up'){ ?>

			<h2> Dashboard Admin Register</h2>

<?php if(!empty($msg)){
	echo '<p style="color: red;width: 100%;text-align: center;">'.$msg.'</p>';
	} ?>

			<div class="form-style-agile">
				<label>Email Id</label>
				<input placeholder="Username" name="email" type="text" required>
			</div>
			<div class="form-style-agile">
				<label>Password</label>
				<input placeholder="Password" name="password" type="password" required>
			</div>
			<div class="form-style-agile">
				<label>Confirm Password</label>
				<input placeholder="Confirm Password" name="repassword" type="password" required>
			</div>
						<!-- checkbox -->
			<div class="wthree-text">
				<ul>
					<li style="font-size: 12px; color:#fff; line-height: 28px;">
						Already register ? <a href="?w=login" style="font-size: 12px; color:#fff;">Sign In</a>
					</li>
				</ul>
			</div>
			<!-- //checkbox -->

		<?php }elseif($_REQUEST['q'] == 'forgot_pwd'){ ?>

		<h2> Dashboard Forgot Password</h2>
			<div class="form-style-agile">
				<label>Email Id</label>
				<input placeholder="Email Id" name="email" type="text" required />
			</div>
		<?php }else{ ?>
			<h2> Dashboard Login</h2>
			<div class="form-style-agile">
				<label>Email Id</label>
				<input placeholder="Email Id" name="email" type="text" required />
			</div>
			<div class="form-style-agile">
				<label>Password</label>
				<input placeholder="Password" name="pwd" type="password" required />
			</div>
						<!-- checkbox -->
			<div class="wthree-text">
				<ul>
					<li style="font-size: 12px;">
						<label class="anim"><input type="checkbox" class="checkbox" /><span>Remember Me</span></label>
					</li>
					<li style="font-size: 12px; color:#fff; line-height: 28px;">
						Don't have an account ? <a href="?q=sign_up" style="font-size: 12px; color:#fff;">Sign Up</a> |<a href="?q=forgot_pwd" style="font-size: 12px; color:#fff;">Forgot Password?</a>
					</li>
				</ul>
			</div>
			<!-- //checkbox -->
			<?php } ?>

<?php if($_REQUEST['q'] == 'sign_up'){ ?>
<input type="submit" name="register" value="Register Now">
<?php }elseif($_REQUEST['q'] == 'forgot_pwd'){ ?>
<input type="submit" name="reset_pwd" value="Submit">
<?php }else{ ?>
<input type="submit" name="login" value="Log In">
<?php } ?>
			
		</form>
	</div>
	<div class="footer" style="4vw .3vw .3vw"><p>&copy; 2018. All rights reserved | Powered by <a target="_blank" href="https://www.depextechnologies.com/">Depex Technologies</a></p></div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/canva_moving_effect.js"></script>
</body>
</html>