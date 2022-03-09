<?php 
	
	include("../../config.php");

	if(isset($_POST["playlistName"]) && isset($_POST["username"]))
	{

		$playlistName = $_POST["playlistName"];
		$username = $_POST["username"];
		$date = date("Y-m-d");
		$insertQuery = mysqli_query($con, "INSERT INTO playlists VALUES('', '$playlistName', '$username', '$date')");
	}


	

?>