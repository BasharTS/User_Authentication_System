<?php 
	session_start();
	
	if (!isset($_SESSION['user_id'])) {
		header('location: index.php');
	}
	#error_reporting(0);
	require 'database/connect.php';
	require 'function/general.php';
	require 'function/functions.php';
 ?>