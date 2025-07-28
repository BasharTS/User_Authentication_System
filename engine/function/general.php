<?php 
	function sanitizer($data){
		return mysqli_real_escape_string($GLOBALS['link'], $data);
	}
 ?>