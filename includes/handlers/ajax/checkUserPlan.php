<?php 
	
	include("../../config.php");
	
	if(isset($_POST['username'])) {
		$username = $_POST['username'];
		$query = mysqli_query($con, "SELECT * FROM userplan WHERE username = '$username'");

		if(mysqli_num_rows($query) >= 1)
			echo "True";
		else
			echo "False";
	}

?>