<!DOCTYPE html>
<html>
<head>
	<?php 
		include "include/head_links.php"
	 ?>
	<title>User Registration</title>
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
	<script>
	    // function getImageSource(imageElement) {
	    //     var imageSrc = imageElement.src; // Get the image source
	    //     window.location.href = "signUpImg3.php?img=" + encodeURIComponent(imageSrc); 
	        // Redirect to another PHP file with the image source in the URL
	    //}    
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.18.0/js/md5.min.js"></script>
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
							<div class="left_grid_info" style="margin-right: 100px;">

								<h3>Hybrid User Authentication System...</h3>
								<p>This system provides high security to your account using a hybrid approach to graphical authentication.</p>
								<br>
								
								
								<img class="im1" src="images/cover.png" height="270" width="370">
							</div>
						</div>

						<div class="login_info" style="">
							<!-- Header -->
							<div class="header">
							  <h1>Login Status</h1>
							  <p>Below is the status of the login procedure</p>
							</div>
							<!-- Photo Grid -->
							<div id="result"> </div>
							 <?php
								session_start();
								ob_start();

								include("engine/database/connect.php");
								include("engine/function/functions.php");

								//Get end session time
								$endTime = microtime(true);
								$_SESSION['result']['endTime'] = $endTime;
								
								//Calculate the elapsed time
								$elapsedTime = $_SESSION['result']['endTime'] - $_SESSION['result']['startTime'];
								$elapsedTimeInSeconds = number_format($elapsedTime, 2);
								$el_time = elapsedLogtime($_SESSION['result']['username'], $elapsedTimeInSeconds);
								//end
								
								echo "<p style='font-weight: bolder; font-size: 40px; color: green; text-align: center;'>Logged in Successfully</p>"
							?>
							
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