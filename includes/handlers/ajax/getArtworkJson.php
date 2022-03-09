 <?php
 	

 	include("../../config.php"); 
 	if(isset($_POST['albumId'])){
 		$id = $_POST['albumId'];
 		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id='$id'");
 		$album = mysqli_fetch_array($albumQuery);

 		echo json_encode($album);
 	}

?>