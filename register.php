<!DOCTYPE html>
<html>
<head>
	<?php 
		include "include/head_links.php"

	 ?>
	<title>User Registration</title>
</head>
<body>
	<?php 
		include "include/main_header.php"
	 ?>
		<div class="container">

			<!-- signup form -->
			<div class="signupform">
				<div class="container">
					<div class="agile_info">
						<div class="login_form">
							<div class="left_grid_info">

								<h1>Create Your User Account</h1>
								<p>This system provides high security to your account using a hybrid approach to graphical authentication.</p>
								
								<br>
								
								<img class="im1" src="images/cover.png" height="270" width="370">
							</div>
						</div>

						<div class="login_info">
							<h2>Create New Account</h2>
							<p>Enter your details to create the account. Fields marked with * are required</p>

							 <?php
								session_start();
								ob_start();
								

								include("engine/database/connect.php");
								include("engine/function/functions.php");
								
								if (isset($_POST["submit"])) {

									$username=$_POST['username'];
									$pw=$_POST['password'];
									$password=md5($pw);
									$email=$_POST['email'];
									$phone_number=$_POST['phone_number'];
									$fullname=$_POST['fullname'];
									$idiom1=$_POST['idiom_1'];
									$idiom2=$_POST['idiom_2'];
									$idiom3=$_POST['idiom_3'];
									
									/*// username already used
									$result=mysqli_query($con,"select * from user where username='$name'");
									if (mysqli_num_rows($result)>0)
									{
										header('Location:username_failed.html');
										exit;
										return;
									}

									// email already used
									$result=mysqli_query($con,"select * from user where email='$email'");
									if (mysqli_num_rows($result)>0)
									{
										header('Location:email_failed.html');
										exit;
										return;
									}
										
									// phone already used
									$result=mysqli_query($con,"select * from user where phone=$phone");
									if (mysqli_num_rows($result)>0)
									{
										header('Location:phone_failed.html');
										exit;
										return;
									}*/
													
									$_SESSION['a']['username']=$username;
									$_SESSION['a']['password']=$password;
									$_SESSION['a']['fullname']=$fullname;
									$_SESSION['a']['email']=$email;
									$_SESSION['a']['phone_number']=$phone_number;
									$_SESSION['a']['idiom1']=$idiom1;
									$_SESSION['a']['idiom2']=$idiom2;
									$_SESSION['a']['idiom3']=$idiom3;
									header('Location:register/reg_img1.php');
								}
								

							?>

							<form name="signup" action="" method="post" onsubmit="return validate();">

								<label>Username</label>
								<div class="input-group">
									<span class="fa fa-user"></span>
									<input type ="text" name="username" id="name" placeholder="Enter Your Username" required="" onBlur="test();"> 
								</div>

								<label>Fullname</label>
								<div class="input-group">
									<span class="fa fa-edit"></span>
									<input type ="text" name="fullname" placeholder="Enter Your Fullname" required=""> 
								</div>

								<label>Email Address</label>
								<div class="input-group">
									<span class="fa fa-envelope"></span>
									<input type ="email" name="email" placeholder="Enter Your Email" required=""> 
								</div>

								<label>Phone Number</label>
								<div class="input-group">
									<span class="fa fa-phone"></span>
									<input type ="number" name="phone_number" placeholder="Enter Your Phone Number" required=""> 
								</div>

								<label>IDIOM 1</label>
								<div class="input-group">
									<select id="select" name="idiom_1">
										<?php 
											$record = getIdioms();
											if ($record['feedback'] = 1){
												$block = "<option>Please Select</option>";

												foreach($record['details'] as $row){
													$block .="<option>".$row['idiom']."</option>";
												}
												echo $block;
											}
										 ?>
									</select>
								</div>

								<label>IDIOM 2</label>
								<div class="input-group">
									<select id="select" name="idiom_2">
										<?php 
											$record = getIdioms();
											if ($record['feedback'] = 1){
												$block = "<option>Please Select</option>";

												foreach($record['details'] as $row){
													if ($row['id'] != 1) {
														$block .="<option>".$row['idiom']."</option>";
													}
												}
												echo $block;
											}
										 ?>
									</select> 
								</div>

								<label>IDIOM 3</label>
								<div class="input-group">
									<select id="select" name="idiom_3">
										<?php 
											$record = getIdioms();
											if ($record['feedback'] = 1){
												$block = "<option>Please Select</option>";

												foreach($record['details'] as $row){
													if ($row['id'] != 1 & $row['id'] != 2) {
														$block .="<option>".$row['idiom']."</option>";
													}
												}
												echo $block;
											}
										 ?>
									</select> 
								</div>

								<br>

								<button class="btn btn-block" type="submit" name="submit" id="newColor">Next</button>                
							</form>

							<p class="account">Already have an account? <a href="login.php">Login here</a></p>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
</body>
<!-- JavaScript links -->
<script src="js/validate_signup.js" type="text/javascript"></script>

	<script src="plugins/jquery.js"></script>
	<script src="plugins/bootstrap.min.js"></script>
	<script src="plugins/bootstrap-select.min.js"></script>
	
	
	<script src="plugins/validate.js"></script>
	<script src="plugins/wow.js"></script>
	<script src="plugins/jquery-ui.js"></script>
	<script src="js/script.js"></script>
</html>