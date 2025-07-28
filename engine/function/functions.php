<?php 
	//To get all Idioms
	function getIdioms(){
		global $link;	
		$query = 'SELECT * FROM `idioms_tbl`';
		
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
			$feedback['feedback'] = 1;
			$c = 0;
			while ($row = mysqli_fetch_assoc($result)) {
			$feedback['details'][$c] = $row;
			$c++;
			}
		}else{
			$feedback['feedback'] = 0;
			$feedback['message'] = 'No Record Found!'; 
		}
		return $feedback;
	}
	
	//To get all images
	function getImgs(){
		global $link;	
		$query = 'SELECT * FROM `imgs_tbl`';
		
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) > 0){
			$feedback['feedback'] = 1;
			$c = 0;
			while ($row = mysqli_fetch_assoc($result)) {
			$feedback['details'][$c] = $row;
			$c++;
			}
		}else{
			$feedback['feedback'] = 0;
			$feedback['message'] = 'No Record Found!'; 
		}
		return $feedback;
	}

	//register new user.
	function register($username, $fullname, $email, $phone_number, $idiom1, $idiom2, $idiom3, $imgPass1, $imgPass2, $imgPass3){
		global $link;	
		$username = mysqli_real_escape_string($link, $username);
		$fullname = mysqli_real_escape_string($link, $fullname);
		$email = mysqli_real_escape_string($link, $email);
		$phone_number = mysqli_real_escape_string($link, $phone_number);
		$idiom1 = mysqli_real_escape_string($link, $idiom1);
		$idiom2 = mysqli_real_escape_string($link, $idiom2);
		$idiom3 = mysqli_real_escape_string($link, $idiom3);
		$imgPass1 = mysqli_real_escape_string($link, $imgPass1);
		$imgPass2 = mysqli_real_escape_string($link, $imgPass2);
		$imgPass3 = mysqli_real_escape_string($link, $imgPass3);
		
		$query = "INSERT into `user` (`username`, `fullname`, `email`, `phone_number`, `idiom_1`, `idiom_2`, `idiom_3`, `img_pass1`, `img_pass2`, `img_pass3`) VALUES ('$username', '$fullname', '$email', '$phone_number', '$idiom1', '$idiom2', '$idiom3', '$imgPass1', '$imgPass2', '$imgPass3')";

		$result = mysqli_query($link, $query);

		if ($result != ''){
			$feedback['feedback'] = 1;
			$feedback['message'] = '<Span class="text-center" style = "color:green; font-weight:bold;" >Registration was Successfully! </span>'; 
				session_destroy();
		}else{
			$feedback['feedback'] = 0;
			$feedback['message'] = '<Span class="text-center" id="danger"> Unable to insert record! </span>'.mysqli_error($link); 
				session_destroy();
		}
		return $feedback;
	}

	function compare($word, $filtered_arr){

		if (in_array($word, $filtered_arr)) {
			$_SESSION['$sign']['$step2'];
			header("location: SignUp2.php?2");
		}else{
			echo "<p id='alignCenter' style='color:red'> Wrong password. You have 2 more attempt</p>";
			$attempt = 1;
		}
	}
	function locked($user){
		global $link;
		$username = $user;

		$query = "UPDATE `user` SET `locked` = '1' WHERE `user`.`username` = '$username'";
		$result = mysqli_query($link, $query);
		
		if ($result != ''){
			$feedback['feedback'] = 1;
			$feedback['message'] = '<Span class="text-center" style = "color:red; font-weight:bold; text-align: center;" >User Account Locked! Please Contact System Administrator</span>'; 
		}
		return $feedback;
	}
	function elapsedRegtime($username, $reg_time){
		global $link;
		$username = $username;
		$reg = $reg_time;

		$query = "INSERT INTO `log_tbl` (`username`, `reg_time`) VALUES ('$username', '$reg')";

		$result = mysqli_query($link, $query);
		
		if ($result != ''){
			$feedback['feedback'] = 1;
			$feedback['message'] = '<Span class="text-center" style = "color:green; font-weight:bold; text-align: center;" > Done! </span>'; 
		}
		return $feedback;
	}
	function elapsedLogtime($username, $log_time){
		global $link;
		$username = $username;
		$log = $log_time;

		$query = "INSERT INTO `log_tbl` (`username`, `log_time`) VALUES ('$username', '$log')";

		$result = mysqli_query($link, $query);
		
		if ($result != ''){
			$feedback['feedback'] = 1;
			$feedback['message'] = '<Span class="text-center" style = "color:green; font-weight:bold; text-align: center;" > Done! </span>'; 
		}
		return $feedback;
	}
	
?>