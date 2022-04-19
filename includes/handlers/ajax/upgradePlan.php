<?php 

	include('../../config.php');

	if(isset($_POST['planType']) && isset($_POST['username'])) 
	{
		$username = $_POST['username'];
		$planType = $_POST['planType'];
		$checkQuery = mysqli_query($con, "SELECT * FROM userplan WHERE username = '$username'");

		//if no entry, then simply add the username with the plantype
		if(mysqli_num_rows($checkQuery) == 0)
		{
			$insertQuery = mysqli_query($con, "INSERT INTO userplan VALUES('', '$planType', '$username', current_timestamp())");
			echo "Your Current Plan is - " . $planType;
		}

		//if entry found, then update if a higher plan is chosen, else return message
		else 
		{
			$map = array();
			$map['hourly'] = 1;
			$map['daily'] = 2;
			$map['monthly'] = 3;
			$map['annually'] = 4;

			$row = mysqli_fetch_array($checkQuery);
			$currentPlan = $row['planType'];

			if($map[$currentPlan] < $map[$planType]) 
			{
				$updateQuery = mysqli_query($con, "UPDATE userplan SET planType = '$planType' WHERE username = '$username'");
				$updateQuery = mysqli_query($con, "UPDATE userplan SET startDateTime = current_timestamp() WHERE username = '$username'");
				echo "Your Current Plan is - " . $planType;
			}

			else 
			{
				echo "You Cannot Downgrade";
			}
		}
	}

?>