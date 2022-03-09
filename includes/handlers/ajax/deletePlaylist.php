<?php 
	
	include("../../config.php");

	if(isset($_POST["playlistId"]))
	{
		$playlistId = $_POST['playlistId'];
		$playlistDeleteQuery = mysqli_query($con, "DELETE FROM playlists WHERE id = '$playlistId'");
		$songDeleteQuery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistid = '$playlistId'");
	}
?>