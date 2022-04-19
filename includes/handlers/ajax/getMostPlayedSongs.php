 <?php

 	include("../../config.php"); 
 	
	$query = mysqli_query($con, "SELECT id FROM songs ORDER BY plays DESC");
	$songIdArr = array();
	while($row = mysqli_fetch_array($query))
	{
		array_push($songIdArr, $row['id']);
	}

	echo json_encode($songIdArr);

?>