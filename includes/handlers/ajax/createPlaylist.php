<?php 
	
	include("../../config.php");

	if(isset($_POST["playlistName"]) && isset($_POST["username"]))
	{

		$playlistName = $_POST["playlistName"];
		$username = $_POST["username"];

		//get the current plan
		$currentPlanQuery = mysqli_query($con, "SELECT planType FROM userplan WHERE username = '$username'");
		if(mysqli_num_rows($currentPlanQuery) == 0)
			$currentPlan = "free";
		else
		{
			$row = mysqli_fetch_array($currentPlanQuery);
			$currentPlan = $row['planType'];
		}


		//get the number of playlists
		$numberOfPlaylistQuery = mysqli_query($con, "SELECT count(*) FROM playlists WHERE owner = '$username'");
		$row = mysqli_fetch_array($numberOfPlaylistQuery);
		$numberOfPlaylists = $row['count(*)'];

		$map = array();
		$map["free"] = 0;
		$map["hourly"] = 1;
		$map["daily"] = 3;
		$map["monthly"] = 10;
		$map["annually"] = 999;


		if($map[$currentPlan] < $numberOfPlaylists + 1)
		{
			echo "False";
			exit();
		}

		$date = date("Y-m-d");
		$insertQuery = mysqli_query($con, "INSERT INTO playlists VALUES('', '$playlistName', '$username', '$date')");
		echo "Done!";
	}


	

?>