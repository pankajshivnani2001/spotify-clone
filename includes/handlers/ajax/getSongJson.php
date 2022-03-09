 <?php
 	

 	include("../../config.php"); # to get the $con variable(connection to the database)

 	if(isset($_POST['songId'])){
 		$id = $_POST['songId'];
 		$songQuery = mysqli_query($con, "SELECT * FROM songs WHERE id='$id'");
 		$song = mysqli_fetch_array($songQuery);

 		#anything we echo in php is sent back to the AJAX call.
 		echo json_encode($song);
 	}

?>