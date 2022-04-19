<?php 
	//include('includes/header.php');
	include('includes/includedFiles.php');
?>


<?php

	$artistQuery = mysqli_query($con, "SELECT * FROM artists");
	while($row = mysqli_fetch_array($artistQuery))
	{
		$profilePicPath = "assets/images/ArtistProfilePics/" . $row['profilePicPath'];
		$name = $row['name'];
		$id = $row['id'];
		$artist = new Artist($con, $id);
		$numSongs = count($artist->getSongs());
		$numAlbums = $artist->getNumberOfAlbums();

		echo '
				<div class="entityInfo">
		
					<div class="leftSection">
						<img src="' . $profilePicPath . '">
					</div>

					<div class="rightSection">
						<h2 class="artistLink" onclick="openPage(' . "'artistPage.php?id=" . "$id'" . ')">' . $name. '</h2>
						<span>'. $numSongs . ' Songs</span>	
						<br>
						<span>' . $numAlbums . ' Album(s)</span>
					</div>
				</div>
				<hr>

			 ';
	}

	

?>