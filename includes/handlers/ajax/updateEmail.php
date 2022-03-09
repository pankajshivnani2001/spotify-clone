<?php 

	include("../../config.php");

	if(isset($_POST['email']) && isset($_POST['userLoggedIn']))
	{
		$email = $_POST['email'];
		$username = $_POST['userLoggedIn'];
		if($email != "")
		{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				echo "Email Invalid";
				exit();
			}

			$existingEmailQuery = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

			if(mysqli_num_rows($existingEmailQuery) > 0)
			{
				$row = mysqli_fetch_array($existingEmailQuery);
				if($row['username'] == $username)
					echo "New Email Same as Existing Email";
				else
					echo "Email Already Exists for a Different User";
				
			}

			else
			{
				$updateEmailQuery = mysqli_query($con, "UPDATE users SET email = '$email' WHERE username = '$username'");
				echo "Email Updated";
			}
		}
		else 
		{
			echo "Enter Email";
			exit();
		}
	}

?>