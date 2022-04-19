<?php 
	include("../../config.php");

	if(isset($_POST["playlistId"]) && isset($_POST["songId"]) && isset($_POST["username"]))
	{
		$playlistId = $_POST["playlistId"];
		$songId = $_POST["songId"];
		$username = $_POST['username'];

		//fetch number of songs in playlist
		$numberOfSongsQuery = mysqli_query($con, "SELECT count(*) FROM playlistsongs WHERE playlistId = '$playlistId'");
		$row = mysqli_fetch_array($numberOfSongsQuery);
		$numberOfSongs = $row['count(*)'];

		//get user plan
		$userPlanQuery = mysqli_query($con, "SELECT * FROM userplan WHERE username = '$username'");
		if(mysqli_num_rows($userPlanQuery) == 0)
			$userPlan = "Free";
		else
		{
			$row = mysqli_fetch_array($userPlanQuery);
			$userPlan = $row['planType'];
		}

		//check user plan and number of songs according to it

		$map = array();
		$map["Free"] = 0;
		$map["hourly"] = 3;
		$map["daily"] = 5;
		$map["monthly"] = 15;
		$map["annually"] = 9999;

		if($map[$userPlan] < $numberOfSongs+1)
		{
			echo "Your Plan Does Not Allow To Add More Songs In This Playlist. Please Upgrade....";
			exit();
		}


		$playlistOrderQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlistOrder)+1, 1) AS maxPlaylistOrder FROM playlistsongs WHERE playlistId = '$playlistId'");

		$row = mysqli_fetch_array($playlistOrderQuery);
		$playlistOrder = $row["maxPlaylistOrder"];

		$insertQuery = mysqli_query($con, "INSERT INTO playlistsongs VALUES('', '$songId', '$playlistId', '$playlistOrder')");
	}

?>