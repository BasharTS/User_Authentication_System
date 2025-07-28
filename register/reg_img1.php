<!DOCTYPE html>
<html>
<head>
      <title>Register</title>

      <!-- Meta tag -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    
      <!-- Stylesheets -->
      <link href="../css/styles.css" rel="stylesheet" >
      <link href="../css/style-footer.css" rel="stylesheet" >
	<link href="../css/style1.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
      <link href="../css/style-body.css" rel="stylesheet" type="text/css" media="all"/>
      
      <!-- JavaScript function -->
      <script>
            // passing the selected image reference to slice the image
            function changeIt(img)
            {
                  var name = img.src;
                  console.log(name);
                  window.location.href = "reg_img2.php?var="+name; 
            }      
      </script>
</head>

<body>
<?php
      include "../include/main_header2.php";
      
      session_start();
      ob_start();
      include("../engine/database/connect.php");
      include("../engine/function/functions.php");
      $startTime = microtime(true);
      $_SESSION['a']['startTime'] = $startTime;
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
      			<div class="login_info" style="padding: 10px;">
      				<h3>Face Selection --> STEP 1</h3>
      				<p class="account1">Select the 1st picture for the graphical password.</p>
      				<center>
                                    <?php 
                                          $record = getImgs();

                                          if ($record['feedback'] = 1){
                                                $image_block = array();
                                                foreach($record['details'] as $row){
                                                      array_push($image_block, $row['path']);
                                                }
                                                shuffle($image_block);
                                                
                                                $block = '';
                                                for ($i=0; $i < 9 ; $i++) { 
                                                      $block .="<img class='im' src='../images/pw/".$image_block[$i]."' onclick='changeIt(this)' height='120' width='120'>";
                                                }
                                                echo $block;
                                          }
                                     ?>
      				</center>
      			</div>
      		</div>
      	</div>
      </div>

      <!-- footer -->
      <footer class="footer">
            <br>
            <h3 id="alignCenter">Hybrid User Authentication Scheme &copy; 2025</h3>
      </footer>
</div>
<script src="../css/plugins/jquery.js"></script>
<script src="../css/plugins/bootstrap.min.js"></script>
<script src="../css/plugins/bootstrap-select.min.js"></script>

<script src="../css/plugins/validate.js"></script>
<script src="../css/plugins/wow.js"></script>
<script src="../css/plugins/jquery-ui.js"></script>
<script src="../js/script.js"></script>

</body>
</html>