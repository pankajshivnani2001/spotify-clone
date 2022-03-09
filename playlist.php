<?php 

	include("includes/includedFiles.php");
	if(isset($_GET['id'])) {
		$playlistId = $_GET['id'];
	}
	else {
		header("Location: index.php");
	}

	$playlist = new Playlist($con, $playlistId);
?>

<div class="entityInfo">
	
	<div class="leftSection">
		<img src="assets/images/icons/playlist.png">
	</div>

	<div class="rightSection">
		<h2><?php echo $playlist->getPlaylistName(); ?></h2>
		<span>By <?php echo $playlist->getOwner(); ?></span>
		<br>
		<span><?php echo $playlist->getNumberOfSongs(); ?> Songs</span>
		<br>
		<?php 

			echo "<button class='button' style='margin-top: 20px;' onclick='deletePlaylist(\"$playlistId\")'>Delete Playlist</button>";

		?>
		

	</div>
</div>
	


<div class="tracklistContainer">
	<div class="tracklist">
		<ul>
			<?php 

				$songIdArray = $playlist->getSongIdArray();
				$listCount = 1;
				foreach($songIdArray as $songId){
					$playlistSong = new Song($con, $songId);
					$songArtist = $playlistSong->getArtist();
					$songTitle = $playlistSong->getTitle();
					$artistName = $songArtist->getName();
					$songDuration = $playlistSong->getDuration();

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
	<?php echo "<div class='item' onclick='deleteFromPlaylist(". $_GET['id'] .")'>Delete From Playlist</div>"; ?>
</nav>