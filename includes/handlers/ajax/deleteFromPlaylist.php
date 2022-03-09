<?php 

	include("../../config.php");

	if(isset($_POST["songId"]) && isset($_POST["playlistId"])) {
		$playlistId = $_POST['playlistId'];
		$songId = $_POST['songId'];
		$deleteQuery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistId = '$playlistId' AND songId = '$songId'");
	}
	

?>