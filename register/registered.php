<!DOCTYPE html>
<html>
<head>
      <title>Register</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta charset="utf-8">
    
      <!-- Stylesheets -->
      <link href="../css/styles.css" rel="stylesheet" >
      <link href="../css/style-footer.css" rel="stylesheet" >
      <link href="../css/style1.css" rel="stylesheet">
      <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="../css/style-body.css" rel="stylesheet" type="text/css" media="all"/>
      
      <script>
      // passing the selected image reference to slice the image
      function changeIt(img)
      {
            var name = img.src;
            console.log(name);
            window.location.href = "reg_img4.php?var="+name; 
      }      
      </script>

</head>
<body>
<?php
      include "../include/main_header2.php";
?>
	<!-- signup form -->
	<div class="signupform">
		<div class="container">
			<div class="agile_info">
				<div class="login_form">
					<div class="left_grid_info">

						<h2>User Account - Face Selection</h2>
	                              <p>This system provides high security to your account using a hybrid approach to graphical authentication.</p>
	                              <br>
	                              <p style="font-weight: bolder;">You are going to need the faces you select now for future login. Remember them!</p>
	                              
	                              <br>
						
						<img class="im1" src="../images/cover.png" height="270" width="370">
					</div>
				</div>

				<div class="login_info">
					<h3> Account Registration Status </h3>
                        	<p class="account1">You are going to need the 3 Idioms & 3 Pictures to log into the system in the future </p>

					 <?php
					session_start();
					ob_start();
					include("../engine/database/connect.php");
      				include("../engine/function/functions.php");

					//Get end session time
					$endTime = microtime(true);
					$_SESSION['a']['endTime'] = $endTime;
					
					//Calculate the elapsed time
					$elapsedTime = $_SESSION['a']['endTime'] - $_SESSION['a']['startTime'];
					$elapsedTimeInSeconds = number_format($elapsedTime, 2);
					$el_time = elapsedRegtime($_SESSION['a']['username'], $elapsedTimeInSeconds);
					//end
						
					if (isset($_POST['confirm'])) {
						if (isset($_SESSION['a'])) {
						      
                                    //get the img path from SESSION
                                    $img1 = $_SESSION['a']['img_pass_1'];
                                    $img2 = $_SESSION['a']['img_pass_2'];
                                    $img3 = $_SESSION['a']['img_pass_3'];
                                    
                                    $imgArr1 = explode('/', $img1);
                                    $imgArr2 = explode('/', $img2);
                                    $imgArr3 = explode('/', $img3);

                                    // move the internal pointer to the end of the array
                                    end($imgArr1);
                                    end($imgArr2);
                                    end($imgArr3);

                                    // fetches the key of the element pointed to by the internal pointer
                                    $key1 = key($imgArr1);
                                    $key2 = key($imgArr2);
                                    $key3 = key($imgArr3);
                                    
                                    //get the name of the images & encrypt them
                                    $imgPass1 = $imgArr1[$key1];
                                    $imgPass2 = $imgArr2[$key2];
                                    $imgPass3 = $imgArr3[$key3];
                                    //the rest of the variable
                                    $username = $_SESSION['a']['username'];
                                    $fullname = $_SESSION['a']['fullname'];
                                    $email = $_SESSION['a']['email'];
                                    $phone_number = $_SESSION['a']['phone_number'];
                                    $idiom1 = $_SESSION['a']['idiom1'];
                                    $idiom2 = $_SESSION['a']['idiom2'];
                                    $idiom3 = $_SESSION['a']['idiom3'];
                                    
                                    $result = register($username, $fullname, $email, $phone_number, $idiom1, $idiom2, $idiom3, $imgPass1, $imgPass2, $imgPass3);
                                    if ($result['feedback'] == 1) {
                                    	echo $result['message'];
                                    }else{
                                    	echo $result['message'];
                                    }
                              }  
                        }

					?>

					<p class="account">You can now log in --> <a href="../login.php">Login here</a></p>
				</div>
			</div>
		</div>
	</div>		
</div>

<!-- footer -->
<footer class="footer">
     <br>
     <h3 id="alignCenter">Hybrid User Authentication Scheme &copy; 2025</h3>
</footer>
<!-- JavaScript links -->
<script src="js/validate_signup.js" type="text/javascript"></script>

	<script src="plugins/jquery.js"></script>
	<script src="plugins/bootstrap.min.js"></script>
	<script src="plugins/bootstrap-select.min.js"></script>
	
	
	<script src="plugins/validate.js"></script>
	<script src="plugins/wow.js"></script>
	<script src="plugins/jquery-ui.js"></script>
	<script src="js/script.js"></script>
</body>
</html>