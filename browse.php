<?php 

	//include('includes/header.php');
	include('includes/includedFiles.php');
	include('includes/classes/Discover.php');
	$d = new Discover($con);
?>


<div class="entityInfo">
	
	<div class="leftSection">
		<img src="assets/images/spotify.png">
	</div>

	<div class="rightSection">
		<h1 style="font-size: 40px; letter-spacing: 1px;"><?php echo "Discover Spotify"; ?></h1>	
		<br>
		<div class="infoContainer">
			<span class="browseLink" onclick='openPage("browse.php")'><?php echo $d->getTotalSongs() . " Songs" ?> </span>
			<br>
			<span class="browseLink" onclick='openPage("browseAllAlbums.php")'><?php echo $d->getTotalAlbums() . " Albums" ?> </span>
			<br>
			<span class="browseLink" onclick='openPage("browseAllGenres.php")'><?php echo $d->getTotalGenres() . " Genres" ?> </span>
			<br>
			<span class="browseLink" onclick='openPage("browseAllArtists.php")'><?php echo $d->getTotalArtists() . " Artists" ?> </span>
		</div> 
	</div>
</div>

<h1 class="pageHeadingBig">All Songs</h1>

<div style="overflow: hidden; width: 100%;">
	<div class="filerList" style="float: right;">
		<select class="filterListSelect">
			<option class="filter-item" value="Sort By">Sort By</option>
			<option class="filter-item" value="Most Played">Most Played</option>
			<option class="filter-item" value="Least Played">Least Played</option>
			<option class="filter-item" value="Longest Duration">Longest Duration</option>
			<option class="filter-item" value="Shortest Duration">Shortest Duration</option>
		</select>
	</div>
</div>



<div class="tracklistContainer">
	<div class="tracklist">
		<ul>
			<?php 

				if(isset($_GET['sortBy']))
				{
					$sortBy = $_GET['sortBy'];

					if($sortBy == '1')
						$songIdArray = $d->getSongsSortedByPlays();
					else if($sortBy == '2')
					{
						$songIdArray = $d->getSongsSortedByPlays();
						$songIdArray = array_reverse($songIdArray);
					}
					else if($sortBy == '3')
						$songIdArray = $d->getSongsSortedByDuration();

					else if($sortBy == '4')
					{
						$songIdArray = $d->getSongsSortedByDuration();
						$songIdArray = array_reverse($songIdArray);
					}
				}

				else
				{
					$songIdArray = $d->getAllSongs();
				}

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
</nav>


<script>
	var url = window.location.href;
	var selectedIdx = url.split("?")[1].split("=")[1];
	console.log(selectedIdx);
	$("select.filterListSelect").prop("selectedIndex", selectedIdx);
</script>


	

<?php //include('includes/footer.php') ?>

