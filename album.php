<?php 
	//include("includes/header.php");
	include("includes/includedFiles.php");

	if(isset($_GET['id'])){
		$albumId = $_GET['id'];
	}

	else{
		header("Location: index.php");
	}

	$album = new Album($con, $albumId);
	$artist = $album->getArtist();
?>

<div class="entityInfo">
	
	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath();  ?>">
	</div>

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<span>By <?php echo $artist->getName(); ?></span>	
		<br>
		<span><?php echo $album->getNumberOfSongs(); ?> Songs</span>
	</div>
</div>
	

<div class="tracklistContainer">
	<div class="tracklist">
		<ul>
			<?php 

				$songIdArray = $album->getSongIdArray();
				$listCount = 1;
				foreach($songIdArray as $songId){
					$albumSong = new Song($con, $songId);
					$albumArtist = $albumSong->getArtist();
					$songTitle = $albumSong->getTitle();
					$artistName = $albumArtist->getName();
					$songDuration = $albumSong->getDuration();

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


							<div class='trackOptions'>
								<input type='hidden' class='songId' value=". $songId ."> 
								<img class='options' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
							</div>

							<div class='trackDuration'>
								<span class='duration'> $songDuration </span>
							</div>

						</li>
					";

					$listCount = $listCount + 1;
				}
			?>


			<script>
				var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
				tempPlaylist = JSON.parse(tempSongIds);

			</script>

		</ul>
	</div>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">

	<select class="item playlist">
		<option value=""> Add to Playlist </option>

		<?php  

			$playlists = $user->getPlaylists();

			while($row = mysqli_fetch_array($playlists))
			{
				$playlistId = $row["id"];
				echo "<option value='$playlistId'>". $row['name'] ."</option>";
			}

		?>
		
	</select>
	<div class="item">Item1</div>
	<div class="item">Item2</div>
</nav>




<?php 
	//include("includes/footer.php");
?>