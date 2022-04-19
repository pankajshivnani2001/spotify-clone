

<?php 

	//include('includes/header.php');
	include('includes/includedFiles.php');
	include('includes/classes/Genre.php');

	echo '<h1 style="text-align: center; margin-top: 30px">Genres</h1>';

	$genreQuery = mysqli_query($con, "SELECT id FROM genres");

	echo '

				<div class="tracklistContainer">
				<div class="tracklist">
					<ul>
			';
	$songIdArray = array();
	while($row = mysqli_fetch_array($genreQuery))
	{
		$genreId = $row['id'];
		$genre = new Genre($con, $genreId);
		$genreName = $genre->getGenreName();
		$genreImage = $genre->getGenreImage();
		$genreSongs = $genre->getGenreSongs();

		echo '	
			<div class="entityInfo">
			
				<div class="leftSection">
					<img height="250px" width="250px" src="' . $genreImage .'">
				</div>

				<div class="rightSection">
					<h2 style=' . '"text-align: left;">'. $genreName .'</h2>
					<span>'. count($genreSongs) .' Songs</span>	
				</div>
			</div>
		';


		

		$listCount = 1;
		
		foreach($genreSongs as $songId)
		{
			$albumSong = new Song($con, $songId);
			$albumArtist = $albumSong->getArtist();
			$songTitle = $albumSong->getTitle();
			$artistName = $albumArtist->getName();
			$songDuration = $albumSong->getDuration();
			array_push($songIdArray, $songId);
			echo "
				<li class='tracklistRow'>

					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $songId . "\", tempPlaylist, true)'>
						<span class='trackNumber'> $listCount </span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'> $songTitle </span>
						<span class='artistName'> $artistName </span>
					</div>



					<div class='trackDuration'>
						<span class='duration'> $songDuration </span>
					</div>

				</li>
			";

			$listCount = $listCount + 1;
		}

		echo "<hr>";
	}

?>

<script>
	var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
	tempPlaylist = JSON.parse(tempSongIds);
</script>







