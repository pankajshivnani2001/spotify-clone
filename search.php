<?php
	
	include("includes/includedFiles.php");

	if(isset($_GET['term'])){
		$term = urldecode($_GET['term']);

	}

	else{
		$term = "";
	}

?>

<div class="searchContainer">
	<h4>Search for an Artist, Album, or Song</h4>
	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="start typing..." onfocus="this.value=this.value">
	
</div>


<script>

	//to make sure that the cursor remains at the text input field even on page reload

	$(document).ready(function(){
		$(".searchInput").focus();
        var search = $(".searchInput").val();
        $(".searchInput").val('');
        $(".searchInput").val(search);
	 })

	$(function(){
		

		$(".searchInput").keyup(function(){	//when key is up, that is, the user is finished typing, get the clear the timer, get the input value and load the search page with the term after a wait of 2000milli secs
			clearTimeout(timer);

			timer = setTimeout(function() {
				var val = $(".searchInput").val();
				openPage("search.php?term=" + val);
			}, 2000)

		})
	})


</script>


<?php

	if($term == ""){
		exit();
	}
?>

<div class="tracklistContainer borderBottom">
	<h2>Songs</h2>
	<div class="tracklist">
		<ul>
			<?php 

				$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%'");

				if(mysqli_num_rows($songsQuery) == 0){
					echo "<span class='noResults'> No Songs found for '". $term ."'</span>";
				}


				$songIdArray = array();
				$listCount = 1;
				
				while($row = mysqli_fetch_array($songsQuery)){

					array_push($songIdArray, $row['id']);


					$artistSong = new Song($con, $row['id']);
					//$albumArtist = $artistSong->getArtist();
					$songTitle = $artistSong->getTitle();
					//$artistName = $albumArtist->getName();
					$songDuration = $artistSong->getDuration();

					echo "
						<li class='tracklistRow'>

							<div class='trackCount'>
								<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $row['id'] . "\", tempPlaylist, true)'>
								<span class='trackNumber'> $listCount </span>
							</div>

							<div class='trackInfo'>
								<span class='trackName'> $songTitle </span>
								
							</div>


							<div class='trackOptions'>
								<input type='hidden' class='songId' value=". $row['id'] ."> 
								<img class='options' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
							</div>

							<div class='trackDuration'>
								<span class='duration'> $songDuration </span>
							</div>

						</li>
					";
					$listCount += 1;
				}
			?>


			<script>
				var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
				tempPlaylist = JSON.parse(tempSongIds);
			</script>

		</ul>
	</div>
</div>


<div class="gridViewContainer" style="border-bottom: 1px solid #fff;">
	<h2>Albums</h2>
	<?php 
		

		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '%$term%'");
		if(mysqli_num_rows($albumQuery) == 0){
					echo "<span class='noResults'> No Albums found for '". $term ."'</span>";
				}

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


<div class="artistsContainer">
	<h2>Artists</h2>
	<?php
		

		$artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '%$term%'");
		if(mysqli_num_rows($artistQuery) == 0){
			echo "<span class='noResults'> No Artists found for '" . $term . "'</span>";
		}

		while($row = mysqli_fetch_array($artistQuery)){
			$artist = new Artist($con, $row['id']);
			$artistPageUrl = "artistPage.php?id=" . $artist->getId();
			$artistName = $artist->getName();

			echo "<div class='searchRowResult'>

					<div class='artistName'>
						<span role='link' tabindex='0' onclick='openPage(\"$artistPageUrl\")'>
							$artistName
						</span>
					</div>

				</div>";
		
		}


	?>
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