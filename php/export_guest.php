<?php

	//database connection info
	require_once('db_connect.php');
	
	//query detail
	$check = "SELECT * FROM guests" ;
	
	//run the query
	$res = $con->query($check);
	
	//prep the file
	$FileName = 'guest_info_' . date("Y-m-d_H:i:s") . '.csv';

	//prep the data
	$payload = "First Name,Last Name,e-mail \n";
	while($row = mysqli_fetch_assoc($res)) {
		$payload .= $row['first_name'] . ','. $row['last_name'] . ','. $row['email'] . "\n";
	}
	
	//php csv export
	header('Content-Type: application/csv'); 
	header("Content-length: " . filesize($NewFile)); 
	header('Content-Disposition: attachment; filename="' . $FileName . '"'); 
	echo $payload;
	exit();  
?>