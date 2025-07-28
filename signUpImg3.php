<!DOCTYPE html>
<html>
<head>
	<?php 
		include "include/head_links.php"
	 ?>
	<title>User Registration</title>
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
	<script>
		/*function redirectToProcess(buttonText) {
	      var hashedButtonText = md5(buttonText);
	      var encodedHashedButtonText = encodeURIComponent(hashedButtonText);
	      window.location.href = 'signUpImg.php?hashedButtonText=' + encodedHashedButtonText;
	    }*/
	    function getImageSource(imageElement) {
	        var imageSrc = imageElement.src; // Get the image source
	        window.location.href = "signUpImg3.php?img=" + encodeURIComponent(imageSrc); 
	        // Redirect to another PHP file with the image source in the URL
	    }    
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
								<p>Remember the 3 images you selected during registration?</p>
								<p>Identify & click on one of the 3 images</p>
								
								<img class="im1" src="images/cover.png" height="270" width="370">
							</div>
						</div>

						<div class="login_info" style="padding-top: 0; margin: 0;">
							<!-- Header -->
							<div class="header">
							  <h3>Picture Password --> STEP 3</h3>
							  <p>Select one image out of your three chosen picture Password</p>
							</div>
							 <?php
								session_start();
								ob_start();

								include("engine/database/connect.php");
								include("engine/function/functions.php");
								

								//Get the users details from session
								$record = $_SESSION['result'];
								 
								$user = $record['username'];
								$conc_imgs = $record['img_pass1']." ".$record['img_pass2']." ".$record['img_pass3'];
								$user_images = explode(" ", $conc_imgs);
								
								shuffle($user_images);
								//End - Get the user`s detail from session
								
				
								//Get the clicked button
								if(isset($_GET['img'])){
								    $image = $_GET['img'];
									$img_arr = explode('/', $image);
									end($img_arr);
									$key = key($img_arr);
									$pass_image = $img_arr[$key];

									if(in_array($pass_image, $user_images)) {
								    	$_SESSION['result']['pass_img3'] = $pass_image;
								    	
								    	header("location: http://localhost/Graphical_System/dashboard.php");
								    }else{
								    	//Handle Wrong attempt
										if (isset($_SESSION['result']['attempt'])) {
											if ($_SESSION['result']['attempt'] <3) {
												$_SESSION['result']['attempt'] ++;
												echo "<p style='color:red; font-weight:bold'> Wrong pass-word! The user will be locked out after 3 wrong attempt </p>";
											}elseif($_SESSION['result']['attempt'] == 3){
												$record = $_SESSION['result'];
												$isLocked = locked($record['username']);
												if ($isLocked['feedback'] == 1) {
													echo $isLocked['message'];
													$redirectUrl = 'http://localhost/Graphical_System/login.php';
													$delaySeconds = 3;
													header("Refresh: $delaySeconds; URL=$redirectUrl");
													exit();
												}
											}	
										}else{
											$_SESSION['result']['attempt'] = 1;
											echo "<p style='color:red; font-weight:bold'> Wrong password! You have 2 MORE wrong ATTEMPT & the system is LOCKED </p>";
										}
									}
								    	
								}
								
								//Get all the images in the database & manipulate them
								$imgs = getImgs();

								if ($imgs['feedback'] = 1){
									$img_arr = array();
									foreach($imgs['details'] as $row){
										if ($row['path'] != $record['img_pass1'] && $row['path'] != $record['img_pass2'] && $row['path'] !=$record['img_pass3']) {
											$img = $row['path'].' ';

											//appending all images to the array - $img_arr
											array_push($img_arr, $img);
										}
									}
									shuffle($img_arr);

									//Taking 9 imagess from the filtered images array bank
									$selected = array();
									for ($i=0; $i < 11; $i++) { 
										array_push($selected, $img_arr[$i]);
									}
									/*Combining user chosen idioms with idiom bank
									adding password to the selected idioms*/
									array_unshift($selected, $user_images[1]);
									
									//shuffle the altered array
									shuffle($selected);

									//get array lenght
									$array_length = count($selected);

									//Output items 9 images on the screen

									for($i = 0; $i < $array_length; $i++){
										$image = $selected[$i];
									    echo "<center style = 'float: left;'>
									    	  	<img class='im' src='images/pw/distorted/".$image."' onclick='getImageSource(this)' height='100' width='100' style = 'margin: 2px; border-radius: 5px; border: 3px solid maroon;'>
									    	  </center>";
										    
									}
								}
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