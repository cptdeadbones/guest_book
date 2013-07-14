<!DOCTYPE html>
<html>

	<script src="../javascript/verify_form.js"></script>
	<meta name="viewport" content="width=768px, munumum-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../css/guest_book_styles.css"/>
	
	<div id="form" class="form">
	<form id="form" name="form" method="post" action="signin.php">

		<h1 class="form">Please Sign In</h1>

		<label class="form">First Name</label>
		<input class="form" type="text" name="first_name" id="first_name" />

		<label class="form">Last Name</label>
		<input class="form" type="text" name="last_name" id="last_name" />

		<label class="form">Email</label>
		<input class="form" type="email" name="email" id="email" />

		<select class="form" name="how" id="how"> 
		<option> How did you hear about us?</option>

			<?php
				require_once('db_connect.php');
			
				$sql = "SELECT * FROM `sources`";
				$res = $con->query($sql);
			
				while($row = mysqli_fetch_assoc($res)){
					echo '<option value="'.$row['how'].'">'.$row['how'].'</option>';
				}
		
    			?>
    	</select> 
    	
    	<select class="form" name="why" id="why"> 
	    <option> What brought you in today?</option>
    		
    		<?php
				require_once('db_connect.php');
			
				$sql = "SELECT * FROM `reasons`";
				$res = $con->query($sql);
			
				while($row = mysqli_fetch_assoc($res)){
					echo '<option value="'.$row['why'].'">'.$row['why'].'</option>';
				}
		
    			?>
    	</select> 


	<button class="form" type="submit" value="Submit" onclick="javascript:return validateForm('form');">Sign In</button>
	<button class="form" type="button" onclick="location.href='../index.html'"> Back </button> 


	</form>
	</div>

	<iframe class="footer" src="../footer.html"></iframe>	


</html>