<?php

	//database connection info
	require_once('db_connect.php');
	
	//query detail
	$check = "SELECT * FROM visits" ;
	
	//run the query
	$res = $con->query($check);
	
	//prep the file
	$FileName = 'visits_info_' . date("Y-m-d_H:i:s") . '.csv';

	//prep the data
	$payload = "Time,First Name,Last Name,e-mail,How,Why \n";
	while($row = mysqli_fetch_assoc($res)) {
	
		//find the visitors name	
		$guest_info_q = "SELECT * FROM guests WHERE `id` = $row[visitor_id] " ;
		$res2 = $con->query($guest_info_q);
		$guest_info = mysqli_fetch_assoc($res2);
		
		//find out how they got here
		$how_q = "SELECT * FROM sources WHERE `id` = $row[how] " ;
		$res3 = $con->query($how_q);
		$how = mysqli_fetch_assoc($res3);
		
		//find out why they are here
		$why_q = "SELECT * FROM reasons WHERE `id` = $row[why] " ;
		$res4 = $con->query($why_q);
		$why = mysqli_fetch_assoc($res4);
		
		//add it to the payload
		$payload .= $row['Time'] . ',' .
					$guest_info['first_name'] . ',' .
					$guest_info['last_name'] . ',' .
					$guest_info['email'] . ',' .
					$how['how'] . ',' . 
					$why['why'] . ',' .    
					"\n" ;
	}
	
	//php csv export
	header('Content-Type: application/csv'); 
	header("Content-length: " . filesize($NewFile)); 
	header('Content-Disposition: attachment; filename="' . $FileName . '"'); 
	echo $payload;
	exit();  
?>