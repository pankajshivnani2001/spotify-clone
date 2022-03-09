<?php
	include("includes/includedFiles.php");

	if(isset($_GET['id'])) {
		$artistId = $_GET['id'];
	}

	else {
		header("Location : index.php");
	}

	$artist = new Artist($con, $_GET['id']);
	
?>

<div class="entityInfo borderBottom">
	<div class="centerSection">
		<div class="artistInfo">
			<h1 class="artistName">
				<?php echo $artist->getName(); ?>
			</h1>

			<div class="headerButtons">
				<button class="button green" onclick="playFirstSong()">Play</button>
			</div>
		</div>
	</div>
</div>

<div class="tracklistContainer borderBottom">
	<h2>Songs</h2>
	<div class="tracklist">
		<ul>
			<?php 

				$songIdArray = $artist->getSongs();
				$listCount = 1;
				foreach($songIdArray as $songId){

					if($listCount > 5){
						break;
					}

					$artistSong = new Song($con, $songId);
					//$albumArtist = $artistSong->getArtist();
					$songTitle = $artistSong->getTitle();
					//$artistName = $albumArtist->getName();
					$songDuration = $artistSong->getDuration();

					echo "
						<li class='tracklistRow'>

							<div class='trackCount'>
								<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $songId . "\", tempPlaylist, true)'>
								<span class='trackNumber'> $listCount </span>
							</div>

							<div class='trackInfo'>
								<span class='trackName'> $songTitle </span>
								
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



<div class="gridViewContainer">
	<h2>Albums</h2>
	<?php 

		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist = '$artistId'");

		while ($row = mysqli_fetch_array($albumQuery)) {
			$title = $row['title'];
			$artworkSrc = $row['artworkPath'];
			$id = $row['id'];

			echo "

				<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=$id\")'>
					
						<img src='$artworkSrc'>
						<div class='gridViewInfo'>
							$title
						</div>
					</span>
				</div>


			";
		}

	?>

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