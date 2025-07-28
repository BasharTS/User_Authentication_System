<!DOCTYPE html>
<html>
<head>
	<?php 
		include "include/head_links.php"
	 ?>
	<title>User Registration</title>
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
	<script>
		function redirectToProcess(buttonText) {
	      var hashedButtonText = md5(buttonText);
	      var encodedHashedButtonText = encodeURIComponent(hashedButtonText);
	      window.location.href = 'signUp2.php?hashedButtonText=' + encodedHashedButtonText;
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
							<div class="left_grid_info">

								<h3>Hybrid User Authentication System...</h3>
								<p>This system provides high security to your account using a hybrid approach to graphical authentication.</p>
								<br>
								<p>Remember the Idioms you selected during registration?</p>
								<p>You are expected to identify & click on words that makes up part of any of the idioms</p>
								
								<img class="im1" src="images/cover.png" height="270" width="370">
							</div>
						</div>

						<div class="login_info">
							<h2>Select Your Password --> STEP 2</h2>
							<p>Click on word that makes up part of your favorite Idiom</p>
							<div id="result"> </div>
							 <?php
								session_start();
								ob_start();

								include("engine/database/connect.php");
								include("engine/function/functions.php");
								

								 //Get the users details from session
								 $record = $_SESSION['result'];
								 $user = $record['username'];
								 $user_idioms = $record['idiom_1']." ".$record['idiom_2']." ".$record['idiom_3'];
								 
								 $user_idiom = explode(" ", $user_idioms);
								 
								 $filtered_arr = array();
								for ($i=0; $i < count($user_idiom); $i++) {
									$single_word = $user_idiom[$i];
									if (strlen($single_word) > 3  && $single_word != "Your" && $single_word != "Than") {
								    	array_push($filtered_arr, $single_word);
								    }
								}
								shuffle($filtered_arr);
								//End - Get the user`s detail from session


								//Get the clicked button
								if(isset($_GET['hashedButtonText'])){
								    $pass2 = $_GET['hashedButtonText'];
								    $md5ed = array();
								    for ($i=0; $i < count($filtered_arr) ; $i++) {
								    	array_push($md5ed, md5($filtered_arr[$i]));
								    }

								    if (in_array($pass2, $md5ed)) {
								    	$_SESSION['result']['pass2'] = $pass2;
										header("location: http://localhost/Graphical_System/signUp3.php");
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

								//Get all the idioms in the database & manipulate them
								$idioms_arr = getIdioms();
								
								if ($idioms_arr['feedback'] = 1){
									$idioms_set = array();
									foreach($idioms_arr['details'] as $row){
										if ($row['idiom'] != $record['idiom_1'] && $row['idiom'] != $record['idiom_2'] && $row['idiom'] !=$record['idiom_3']) {
											$idiom = $row['idiom'].' ';
											//appending all idioms to the array - $idioms_set
											array_push($idioms_set, $idiom);
										}
									}
									//merging all the array indices into one index
									$mergeArr =implode(' ', $idioms_set);

									//seperating index 0 into multiple indices
									$array_word = explode(' ', $mergeArr);

									// filter the array of idioms
									 $filtered_idiom = array();
									for ($i=0; $i < count($array_word); $i++) {
										$idiom_word = $array_word[$i];
										if (strlen($idiom_word) > 3 && $idiom_word != "your" && $idiom_word != "than") {
									    	array_push($filtered_idiom, $idiom_word);
									    }
									}
									//randomizing the items of the array
									shuffle($filtered_idiom);

									//Taking 14 items from the filtered idiom array bank
									$selected = array();
									for ($i=0; $i < 12; $i++) { 
										array_push($selected, $filtered_idiom[$i]);
									}

									//Combining user chosen idioms with idiom bank
									//adding password to the selected idioms
									array_unshift($selected, $filtered_arr[1]);
									
									//shuffle the altered array
									shuffle($selected);

									//get array lenght
									$array_length = count($selected);

									//Output items 12 word with more than 5 characters
									for($i = 0; $i < $array_length; $i++){
										if ($i < 12) {

										 	$word = $selected[$i];
										    echo "<button class='btn word' name='submit' style='background: maroon' id='myBtn' onclick='redirectToProcess(this.innerText)' >".$word." </button>";
										}
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