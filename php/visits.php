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
	
?>

<!DOCTYPE HTML>

<html>
	<meta name="viewport" content="width=768px, munumum-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../css/guest_book_styles.css">
	<script type="text/javascript" src="../javascript/sorttable.js"></script>
	
	<div class="visits" style="Float:left;width:15%"> 
		<a href="../backend.html">Back End</a>
	</div>
	
	<div class="visits" style="Float:right;width:25%"> 
	<form id="search" name="search" method="post" action="search.php">
		<input class="search" type="text" name="search" id="search" placeholder="Search for Name or email..." />
		<input type="hidden" name="url" id="url" name="url" value="<?php echo curPageURL();?> ">
		<input type="submit" name="button" id="button" value="Filter" hidden="true" />
	</form>
 	</div>
 	
	<div class="visits">
		<h1 class="visits">Visits Records</h1>
	</div>
 	
<?php

	// database connection info
	require_once('db_connect.php');
	
	// find out how many rows are in the table 
	$sql_q = "SELECT COUNT(*) FROM visits";
	$res = $con->query($sql_q);
	$row = mysqli_fetch_array($res);
	$numrows = $row[0];


	// ------- Build Pagination ---------------

	// number of rows to show per page & total pages
	$rowsperpage = 10;
	$totalpages = ceil($numrows / $rowsperpage);

	// get the current page or set a default
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   		$currentpage = (int) $_GET['currentpage'];
	} else {
	   $currentpage = 1;
	} 

	// if current page is greater than total pages...
	if ($currentpage > $totalpages) {
	   $currentpage = $totalpages;
	}
	 
	// if current page is less than first page...
	if ($currentpage < 1) {
	   $currentpage = 1;
	} 

	// the offset of the list, based on current page 
	$offset = ($currentpage - 1) * $rowsperpage;


	// ------- Build Table ---------------
	
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
	$sql_q = "SELECT * FROM visits ORDER BY Time DESC LIMIT $offset, $rowsperpage";
	$res = $con->query($sql_q);

	// echo data
	while ($row = mysqli_fetch_assoc($res)) {
	   
		$sql = "SELECT * FROM guests WHERE `id` = '$row[visitor_id]'";
		$res2 = $con->query($sql);
		$guest_info = mysqli_fetch_assoc($res2);
		
		$sql = "SELECT * FROM sources WHERE `id` = ". $row['how'];
		$res3 = $con->query($sql);
		$how = mysqli_fetch_assoc($res3);
	
		$sql = "SELECT * FROM reasons WHERE `id` = ". $row['why'];
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
	
	echo "</table><br>\n";


	// ------- Build Pagination Links ---------------
	
	// range of num links to show
	$range = 3;

	echo "<center>";

	// if not on page 1, don't show back links
	if ($currentpage > 1) {
	   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'>First</a> ";
	   $prevpage = $currentpage - 1;
	   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>Prev</a> ";
	} 

	// loop to show links to range of pages around current page
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
	   if (($x > 0) && ($x <= $totalpages)) {
	      if ($x == $currentpage) {
        	 echo " [<b>$x</b>] ";
    	  } else {
	         echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
    	  } 
   		} 
	} 

	// if not on last page, show forward and last page links        
	if ($currentpage != $totalpages) {
	   $nextpage = $currentpage + 1;
	   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>Next</a> ";
	   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>Last</a> ";
	} 
	echo "</center>";
?>

	<iframe class="footer" src="../footer.html"></iframe>
</html>