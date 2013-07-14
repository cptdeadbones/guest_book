<?php
	
		// database info 
		$host = "localhost";
		$username = "test";
		$password = "1234";
		$db = "trial";
	 	
		//connection
		$con = new mysqli($host,$username,$password,$db);
		if($con->connect_errno > 0) {
		 	die("ERROR 01: Failed to connect to MySQL"); 
		}
	
	?>