<?php 

	//database connection info
	require_once('db_connect.php');
	
	echo 'hi';
		
	//let's check if the guest is already in our system
	$check = "SELECT * FROM guests WHERE 
							 `first_name` =  '$_POST[first_name]'
						AND  `last_name` =  '$_POST[last_name]' 
						AND  `email` = '$_POST[email]' " ;
	
	//run the query
	$res = $con->query($check);
						
	//setup sql query to insert guest
	$info = "INSERT INTO guests  (first_name,last_name,email) 
			 VALUES ('$_POST[first_name]', 
			 		 '$_POST[last_name]', 
			 		 '$_POST[email]')" ;
	 
	// visitor not in guests table
	if(mysqli_num_rows($res) == 0){ 
		$con->query($info);
		$visitor_id = $con->insert_id;
	} else { 
	
		// vistor in guests table
	 	$row = mysqli_fetch_assoc($res);
	 	$visitor_id = $row['id'];
	}
	
	//get the how id
	$how_id_q = "SELECT * FROM sources WHERE `how` =  '$_POST[how]' " ;
	$res = $con->query($how_id_q);
	$row = mysqli_fetch_assoc($res);
	$how_id = $row['id'];

	//get the why id
	$why_id_q = "SELECT * FROM reasons WHERE `why` =  '$_POST[why]' " ;
	$res = $con->query($why_id_q);
	$row = mysqli_fetch_assoc($res);
	$why_id = $row['id'];
	
	//insert visit
	$visit = "INSERT INTO visits (visitor_id,why,how) 
		 		VALUES ('$visitor_id', '$why_id', '$how_id')";
	$con->query($visit);
	 	
	//always close the connection
	mysql_close($con);
?>

<!-- Redirect to thank you page using HTML redirect-->

<html>
		<meta http-equiv="refresh" content="0;url=../thanks.html">
</html>