<!DOCTYPE HTML>

<html>
	<meta name="viewport" content="width=768px, munumum-scale=1.0, maximum-scale=1.0" />
	
	<link rel="stylesheet" type="text/css" href="../css/guest_book_styles.css">
	<script src="../javascript/verify_form.js"></script>
	
	<div class="edit_visit" style="Float:left;width:15%"> 
		<a href="../backend.html">Back End</a><br>
		<a href="<?php echo $_GET['url']; ?>">Visit Records</a>
	</div>
	
	<div class="edit_visit">
		<h1 class="edit_visit">Edit Records</h1>
		<form action="update_visit.php" method="post" name="edit_visit" id="edit_visit">

	<?php

	
		require_once('db_connect.php');
	
		$sql = "SELECT * FROM visits WHERE `id` = $_GET[visit_id]";
		$res = $con->query($sql);
		$visit_info = mysqli_fetch_assoc($res);
	
		$sql = "SELECT * FROM guests WHERE `id` = ". $visit_info['visitor_id'];
		$res2 = $con->query($sql);
		$guest_info = mysqli_fetch_assoc($res2);
			
		$sql = "SELECT * FROM sources WHERE `id` = ". $visit_info['how'];
		$res3 = $con->query($sql);
		$how = mysqli_fetch_assoc($res3);
	
		$sql = "SELECT * FROM reasons WHERE `id` = ". $visit_info['how'];
		$res4 = $con->query($sql);
		$why = mysqli_fetch_assoc($res4);
	
		$sql = "SELECT * FROM sources ORDER BY how";
		$res5 = $con->query($sql);
	
		$sql = "SELECT * FROM reasons ORDER BY why";
		$res6 = $con->query($sql);
	
		echo "<table class=\"edit_visit\"> \n";
	
		echo "<tr><td type=\"left\"> Time </td>";
		echo "<td type=\"right\">".$visit_info['Time'];
		echo "</td></tr>";
	
		echo "<tr><td type=\"left\"> First Name </td><td type=\"right\">";
		echo "<textarea name=\"first_name\" class=\"edit_visit\">".$guest_info['first_name'];
		echo "</textarea></td></tr>";
	
		echo "<tr><td type=\"left\"> Last Name </td><td type=\"right\">";
		echo "<textarea name=\"last_name\" class=\"edit_visit\">".$guest_info['last_name'];
		echo "</textarea></td></tr>";

		echo "<tr><td type=\"left\"> email </td><td type=\"right\">";
		echo "<textarea name=\"email\" class=\"edit_visit\">".$guest_info['email'];
		echo "</textarea></td></tr>";
	
		echo "<tr><td type=\"left\"> How </td>";
		echo "<td type=\"right\"> <select class=\"edit_visit\" name=\"how\" >";
		echo "<option>" . $how['how'] . "</option>";
		while ($row2 = mysqli_fetch_assoc($res5)) {
			if($row2['how'] != $how['how']){
				echo "<option>" . $row2['how'] . "</option>";
			}
		}
		echo '</td></tr>';
	
		echo "<tr><td type=\"left\"> Why </td>";
		echo "<td type=\"right\"> <select class=\"edit_visit\" name=\"why\" >";
		echo "<option>" . $why['why'] . "</option>";
		while ($row2 = mysqli_fetch_assoc($res6)) {
			if($row2['why'] != $why['why']){
				echo "<option>" . $row2['why'] . "</option>";
			}
		}
		echo '</td></tr>';
	
		echo "</table>";
		
		echo "<input type=\"hidden\" id=\"guest_id\" name=\"guest_id\" value=".$_GET['guest_id'].">";
		echo "<input type=\"hidden\" id=\"visit_id\" name=\"visit_id\" value=".$_GET['visit_id'].">";
		echo "<input type=\"hidden\" id=\"url\" name=\"url\" value=".$_GET['url'].">";
	
	?>
	
	<br></div>
	<div class="edit_visit_buttons">
		<button class="edit_visit" value="Submit" onclick="javascript:return validateForm('edit_visit');">
			Save
		</button>
		<form><input type="button" class="edit_visit" value="Back" onClick="history.go(-1);return true;"></form>
		<br><br><label class="edit_visit">Changes will not be saved unless you hit 'save'.</label>
	</div></form>

	<iframe class="footer" src="../footer.html"></iframe>	
	
</html>