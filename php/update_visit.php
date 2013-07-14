<?php 
	
	require_once('db_connect.php');
	
	$sql = "UPDATE `guests` SET 
		 `first_name` =  '" . $_POST['first_name'] ."',
		 `last_name` =  '" . $_POST['last_name'] ."',
		 `email` =  '" . $_POST['email'] ."'
		 WHERE  `guests`.`id` =$_POST[guest_id];";
	$con->query($sql);

	$sql = " SELECT * FROM `sources` WHERE `how` = '".$_POST['how']."'";
	$res = $con->query($sql);
	$how = mysqli_fetch_assoc($res);
	
	$sql = " SELECT * FROM `reasons` WHERE `why` = '".$_POST['why']."'";
	$res = $con->query($sql);
	$why = mysqli_fetch_assoc($res);

	$sql = "UPDATE  `visits` SET  
			`why` =  '".$why['id']."',
			`how` =  '".$how['id']."' 
			WHERE  `visits`.`id` ='".$_POST['visit_id']."'";
	$con->query($sql);	

?>

<meta http-equiv="refresh" content="0; url=
	<?php 
		if (!strpos($_POST['url'], 'search')) 
			echo $_POST['url'];
		else
			echo substr($_POST['url'],0,-10)."visits.php"; ?>"> 

