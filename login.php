<!DOCTYPE html>
<html>
<head>
	<!-- mobile responsive meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Link to Icons (font awesome icons) -->
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">

	<!-- Link to three different CSS stylesheet -->
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link href="css/style-body.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="css/style1.css" rel="stylesheet" type="text/css" media="all"/>
	<link rel="stylesheet" href="css/style-footer.css">
	<title>User Registration</title>
</head>
<body>
	<?php 
		session_start();
		ob_start();
		include "include/main_header.php";
		include("engine/database/connect.php");
		include("engine/function/functions.php");
	 ?>
		<div class="container">
			<!-- signup form -->
			<div class="signupform">
				<div class="container">
					<div class="agile_info">
						<div class="login_form">
							<div class="left_grid_info">
								<h1>Log into your account</h1>
								<p>This system provides high security to your account using a hybrid approach to graphical authentication.</p>
								<br>
								<img class="im1" src="images/log.png" height="270" width="370">
							</div>
						</div>
						<div class="login_info">
							<h2>User Login</h2>
							<p>Enter your USERNAME. This is the first step taken to access the system.</p>
							<?php
								if (isset($_POST['submit'])) {
									$username=$_POST['username'];

									// username exist
									$result=mysqli_query($link,"SELECT * FROM `user` WHERE `username`= '$username'");
									
									if (mysqli_num_rows($result)<1){
										echo "<p id='alignCenter' style='color:red'> User does not exist</p>";
									}else{
										$record = mysqli_fetch_assoc($result);

										if ($record['locked'] == 1) {
											echo "<p id='alignCenter' style='color:red'> User Account Locked</p>";
										}else{
											$_SESSION['result'] = $record;

											header('location:signUp.php');
										}
										
									}
								}
							 ?>

							<form name="signup" action="" method="POST" onsubmit="return validate();">
								<label>Username</label>
								<div class="input-group">
									<span class="fa fa-user"></span>
									<input type ="text" name="username" id="username" placeholder="Enter Your Username" required onBlur="test();">
								</div>
								<br>
									<button class="btn btn-block" type="submit" name="submit" id="newColor">Next</button>                
							</form>
							<p class="account">You Don't have an account? <a href="register.php">Register here</a></p>
						</div>
					</div>
				</div>
			</div>		
		</div>
</body>
<script src="js/validate_signup.js" type="text/javascript"></script>

	<script src="plugins/jquery.js"></script>
	<script src="plugins/bootstrap.min.js"></script>
	<script src="plugins/bootstrap-select.min.js"></script>
	
	
	<script src="plugins/validate.js"></script>
	<script src="plugins/wow.js"></script>
	<script src="plugins/jquery-ui.js"></script>
	<script src="js/script.js"></script>
</html>