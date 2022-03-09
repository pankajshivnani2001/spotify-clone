<?php 

	include("../../config.php");

	if(isset($_POST['username']) && isset($_POST['currentPw']) && isset($_POST['newPw']) && isset($_POST['confirmPw'])) {
		$username = $_POST['username'];
		$currentPw = $_POST['currentPw'];
		$newPw = $_POST['newPw'];
		$confirmPw = $_POST['confirmPw'];

		if($currentPw == "" || $newPw == "" || $confirmPw == "") {
			echo "Fill All Fields";
			exit();
		}

		//at this point, we know all the fields have been entered

		$currentPwQuery = mysqli_query($con, "SELECT password FROM users WHERE username = '$username'");
		$row = mysqli_fetch_array($currentPwQuery);
		$existingPw = $row['password'];

		if($existingPw != md5($currentPw))
		{
			echo "Enter Correct Current Password";
			exit();
		}
		
		//at this point we know the user entered the correct current password

		if($newPw != $confirmPw)
		{
			echo "New Passwords Do Not Match";
			exit();
		}

		if(strlen($newPw) > 30 || strlen($newPw) < 5)
		{
			echo "New Password Length Must be Between 5 and 30";
			exit();
		}

		if(preg_match("/[^A-Za-z0-9]/", $newPw))
		{
				echo "Password Must Only Contain Alphanumeric Characters";
				exit();
		}

		// passwords pass the checks. Update into db....

		$encodedPw = md5($newPw);
		$updatePasswordQuery = mysqli_query($con, "UPDATE users SET password = '$encodedPw' WHERE username = '$username'");
		echo "Password Updated";
		exit();

	}

	else {
		echo "Enter All Details";
		exit();
	}

?>