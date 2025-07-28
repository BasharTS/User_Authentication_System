<?php 
	global $link;
	$link = mysqli_connect('localhost', 'root', '', 'graphical_system');
	if (mysqli_connect_errno()) {
		 die(" Database Connection Failed= " .mysqli_connect_error()." (".mysqli_connect_errno().")"
			);
	}
 ?>