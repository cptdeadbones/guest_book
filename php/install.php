<?php
	
	$host = $_POST['host'];
	$username = $_POST['user_name'];
	$password = $_POST['password'];
	$db = $_POST['db_name'];
	
	$how_list = explode(',',$_POST['sources']);
	$why_list = explode(',',$_POST['reasons']);

	//write out db_connect.php file
	$out_file = "db_connect.php";
	$file = fopen($out_file, 'w') or die("can't open file");
	$payload = "<?php
	
		// database info 
		\$host = \"$host\";
		\$username = \"$username\";
		\$password = \"$password\";
		\$db = \"$db\";
	 	
		//connection
		\$con = new mysqli(\$host,\$username,\$password,\$db);
		if(\$con->connect_errno > 0) {
		 	die(\"ERROR 01: Failed to connect to MySQL\"); 
		}
	
	?>";
	fwrite($file, $payload);
	fclose($file);

	//create database
	require_once('db_connect.php');
	
	$create = "CREATE TABLE `visits` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `visitor_id` int(11) NOT NULL,
				  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  `why` int(11) NOT NULL,
				  `how` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;" ;
	
	//run the query
	$res = $con->query($create);
	
	$create = "CREATE TABLE `guests` (
 				 `id` int(11) NOT NULL AUTO_INCREMENT,
				 `first_name` text NOT NULL,
				 `last_name` text NOT NULL,
				 `email` text NOT NULL,
			  PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; " ;


	//run the query
	$res = $con->query($create);

	$create = "CREATE TABLE `sources` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `how` text NOT NULL,
			  PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;" ;
	
	//run the query
	$res = $con->query($create);
	
	$create = "CREATE TABLE `reasons` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `why` text NOT NULL,
			  PRIMARY KEY (`id`)
			  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;" ;
	
	//run the query
	$res = $con->query($create);

	//create sources
	foreach ($how_list as &$how) {
    	$sql_q = "INSERT INTO `sources` (how) 
			 VALUE ('$how')";
		$con->query($sql_q);
	}
	unset($how);
	
	//create reasons
	foreach ($why_list as &$why) {
    	$sql_q = "INSERT INTO `reasons` (why) 
			 VALUE ('$why')";
		$con->query($sql_q);
	}
	unset($why);

?>

<!DOCTYPE html>
<html>

	<meta name="viewport" content="width=768px, munumum-scale=1.0, maximum-scale=1.0" />
	<meta http-equiv="refresh" content="3;url=../index.html">
	<link rel="stylesheet" type="text/css" href="../css/guest_book_styles.css"/>

	<center><h2 class="install_form"> Thank you for installing Guest Book </h2></center>

</html>