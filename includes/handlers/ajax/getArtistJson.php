 <?php
 	

 	include("../../config.php"); 
 	if(isset($_POST['artistId'])){
 		$id = $_POST['artistId'];
 		$artistQuery = mysqli_query($con, "SELECT * FROM artists WHERE id='$id'");
 		$artist = mysqli_fetch_array($artistQuery);

 		echo json_encode($artist);
 	}

?>