<!DOCTYPE HTML>

<html>
	<meta name="viewport" content="width=768px, munumum-scale=1.0, maximum-scale=1.0" />

	<link rel="stylesheet" type="text/css" href="../css/guest_book_styles.css">
	<script type="text/javascript" src="../javascript/sorttable.js"></script>
	
	<div class="visits" style="Float:left;width:10%"> 
		<a href="../backend.html">Back End</a>
		<a href="<?php echo $_POST['url']; ?>">Visit Records</a>
	</div>
 	
	<div class="visits">
		<h1 class="visits">Search Results</h1>
	</div>
 	

<?php

	//helper function
	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
			  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}

	// database connection info
	require_once('db_connect.php');
		
	echo "<table class=\"sortable\"> \n";
	echo "<tr> 
			<th> Time </th> 
			<th> First Name </th> 
			<th> Last Name </th> 
			<th> email </th>
		 	<th> How </th> 
		 	<th> Why </th> 
		 	<th> Edit </th>\n";

	// get the info from the db 
	$sql_q = "SELECT * FROM  `guests` 
		WHERE  `first_name` LIKE  '".$_POST['search']."%'
		OR     `last_name` LIKE  '".$_POST['search']."%'
		OR     `email` LIKE '".$_POST['search']."%'";	
	$res = $con->query($sql_q);

	// echo data
	while ($guest_info = mysqli_fetch_assoc($res)) {
	   
	   $sql_q = "SELECT * FROM `visits` WHERE `visitor_id` = '".$guest_info['id']."'";
	   $res2 = $con->query($sql_q);
	  
	   while ($row = mysqli_fetch_assoc($res2)) {
	   	   
			$sql = "SELECT * FROM sources WHERE `id` = ". $row['how'];
			$res3 = $con->query($sql);
			$how = mysqli_fetch_assoc($res3);
	
			$sql = "SELECT * FROM reasons WHERE `id` = ". $row['how'];
			$res4 = $con->query($sql);
			$why = mysqli_fetch_assoc($res4);
		
			echo "<tr>";
			echo "<td>" . $row['Time'] . "</td>";
			echo "<td>" . $guest_info['first_name'] . "</td>";
			echo "<td>" . $guest_info['last_name'] . "</td>";
			echo "<td>" . $guest_info['email'] . "</td>";
			echo "<td>" . $how['how'] . "</td>";
			echo "<td>" . $why['why'] . "</td>";
		
		
			echo "<td>" . "<button onclick=\"location.href=
				'edit_visit.php?visit_id=".$row['id'].
				"&guest_id=".$guest_info['id'].
				"&url=".curPageURL()."'\">
    			 Edit Record</button>" . "</td>";
    		 
			echo "</tr>\n";   
		} 
	}
	
	echo "</table><br>\n"; 
	   
?>

	<div class="visits"> 
	<center>
		<a href="<?php echo $_POST['url']; ?>">Return to Visit Records</a>
	</center>
	</div>
	
	<iframe class="footer" src="../footer.html"></iframe>
	
</html>