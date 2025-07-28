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
            window.location.href = "reg_img3.php?var="+name; 
      }      
      </script>

</head>

<body>
<div class="container-fluid" id="fullWidth">
      <!--Main Header-->
      <nav class="navbar navbar-default" id="newColor">
            <div class="container">

                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                        </button>
                  </div>

                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                              <li class="active">
                                    <a href="../register.php">Home</a>
                              </li>
                              <li>
                                    <a href="#">About Us</a>
                              </li>
                              <li>
                                    <a href="#">Contact Us</a>
                              </li>
                              <li>
                                    <a href="../logout.php">logout</a>
                              </li>                                            
                        </ul>
                  </div> <!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
      </nav><!--End Main Header -->

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

                              <?php
                                    session_start();
                                    include("../engine/database/connect.php");
                                    include("../engine/function/functions.php");
                                    
                                    if (isset($_GET['var'])) {
                                      $_SESSION['a']['img_pass_1'] = $_GET['var'];
                                    }

                              ?>
					<img class="im1" src="../images/cover.png" height="270" width="370">
				</div>
			</div>
			<div class="login_info" style="padding: 10px;">
			      <h3> Face Selection --> STEP 2</h3>
                        <p class="account1">Select the 2nd picture for the graphical password.</p>
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

<script src="../css/plugins/jquery.js"></script>
<script src="../css/plugins/bootstrap.min.js"></script>
<script src="../css/plugins/bootstrap-select.min.js"></script>

<script src="../css/plugins/validate.js"></script>
<script src="../css/plugins/wow.js"></script>
<script src="../css/plugins/jquery-ui.js"></script>
<script src="../js/script.js"></script>

</body>
</html>