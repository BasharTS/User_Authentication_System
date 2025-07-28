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
                              <?php
                                    session_start();
                                    

                                    include("../engine/database/connect.php");
                                    include("../engine/function/functions.php");
                                    
                                    if (isset($_GET['var'])) {
                                      $_SESSION['a']['img_pass_3'] = $_GET['var'];
                                    }

                              ?>
                              <img class="im1" src="../images/cover.png" height="270" width="370">
                        </div>
                  </div>
                  <div class="login_info" style="padding: 10px;">
                        <h3> Face Selection --> FINAL</h3>
                        <p class="account1">Try to mentally associate your chosen pictures with their corresponding distorted version.</p>
                        <center>
                              <?php 
                                    if (isset($_SESSION['a'])) {
                                          $path1 = $_SESSION['a']['img_pass_1'];
                                          $path2 = $_SESSION['a']['img_pass_2'];
                                          $path3 = $_SESSION['a']['img_pass_3'];
                                          //var_dump($path1);
                                          echo '<img class="im" src="'.$path1.'" height="100" width="100">';
                                          echo '<img class="im" src="'.$path2.'" height="100" width="100">';
                                          echo '<img class="im" src="'.$path3.'" height="100" width="100">';
                                          $path1_img = explode('/', $path1);
                                          $path2_img = explode('/', $path2);
                                          $path3_img = explode('/', $path3);

                                          // move the internal pointer to the end of the array
                                          end($path1_img);
                                          end($path2_img);
                                          end($path3_img);

                                          // fetches the key of the element pointed to by the internal pointer
                                          $key1 = key($path1_img);
                                          $key2 = key($path2_img);
                                          $key3 = key($path3_img);

                                          // get the name of the images
                                          echo "<br>";
                                          echo "<br>";
                                          echo "<h3>Now familiarize yourself with the distorted Images below!</h3>";
                                          $distorted_1 = 'distorted/'.$path1_img[$key1];
                                          $distorted_2 = 'distorted/'.$path2_img[$key2];
                                          $distorted_3 = 'distorted/'.$path3_img[$key3];

                                          
                                          echo '<img class="im" src="../images/pw/'.$distorted_1.'" height="100" width="100">';
                                          echo '<img class="im" src="../images/pw/'.$distorted_2.'" height="100" width="100">';
                                          echo '<img class="im" src="../images/pw/'.$distorted_3.'" height="100" width="100">';

                                          echo '<form method="POST" action="registered.php" name="signUp">
                                                <br><br><button class="btn btn-block" type="submit" name="confirm" id="newColor">Confirm</button></form>';
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