<?php
	$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
	$phpArray = array();

	while($row = mysqli_fetch_array($songQuery)){
		array_push($phpArray, $row['id']);
	}

	$jsonArray = json_encode($phpArray);
?>


<script>
	
	$(document).ready(function() {
		var newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		audioElement.setVolume(0.5);

		setTrack(newPlaylist[0], newPlaylist, false);

		//to prevent highlighting the buttons on setting the progress bars
		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
			e.preventDefault();
		});

		//to move the progressBar according to mouse

		$(".playBackBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".playBackBar .progressBar").mousemove(function(e) {
			if(mouseDown){
				timeFromOffset(e);
			}
		});

		$(".playBackBar .progressBar").mouseup(function(e) {
			timeFromOffset(e);
		});

		$(".volumeBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e) {
			if(mouseDown){
				volumeFromOffset(e);
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e) {
			volumeFromOffset(e);
		});


		$(document).mouseup(function() {
			mouseDown = false;
		})

	});


	//function to set the the progress bar
	function timeFromOffset(mouse){
		var percentMoved = mouse.offsetX / $('.playBackBar .progressBar').width() * 100;
		var seconds = audioElement.audio.duration * (percentMoved / 100);
		audioElement.setTime(seconds);
		playSong();

	}

	function volumeFromOffset(mouse) {
		var volume = mouse.offsetX / $('.volumeBar .progressBar').width();
		if(volume >= 0 && volume <= 1)
				audioElement.setVolume(volume);
	}


	//to move to the next song in the playlist when one song ends
	function nextSong() {
		if(repeat) {
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentSongIndex == currentPlaylist.length - 1){
			currentSongIndex = 0;
		}
		else{
			currentSongIndex += 1;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentSongIndex] : currentPlaylist[currentSongIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function invertRepeat(){
		repeat = !repeat;

		//change the image
		if(repeat) {
			$(".controlButton.repeat img").attr("src", "assets/images/icons/repeat-active.png");
		}
		if(!repeat) {
			$(".controlButton.repeat img").attr("src", "assets/images/icons/repeat.png");
		}
	}

	function previousSong() {
		if(currentSongIndex == 0 || audioElement.audio.currentTime >= 3){
			audioElement.setTime(0);
			playSong();
		}

		else{
			currentSongIndex -= 1;
			setTrack(currentPlaylist[currentSongIndex], currentPlaylist, true);
		}
	}

	function setTrack(trackId, newPlaylist, play) {



		//creating a copy of the currentPlaylist in the shuffle array
		if(newPlaylist != currentPlaylist) {
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice(); //slice() creates a deep copy of the array
			shufflePlaylist = shuffleArray(shufflePlaylist);
		}

		
		if(shuffle){
			currentSongIndex = shufflePlaylist.indexOf(trackId);
		}
		else if(!shuffle){
			currentSongIndex = currentPlaylist.indexOf(trackId);
		}

		//pauseSong();
		//making AJAX calls
		// AJAX -> Asynchronous Javascript and XML
		// AJAX used for interactive communication with the database
		//$.POST(URL, {data we are giving to the url}, function(data we are recieving){function body to do something with the data})


		$.post("includes/handlers/ajax/getSongJson.php", {songId : trackId}, function(data) {
			
			var song = JSON.parse(data);
			//console.log(song);
			audioElement.setTrack(song);
			$(".trackName span").text(song.title);

			$.post("includes/handlers/ajax/getArtistJson.php", {artistId : song.artist}, function(data){
				var artist = JSON.parse(data);
				//console.log(artist.name);
				$(".trackInfo .artistName span").text(artist.name);
				$(".trackInfo .artistName span").attr("onclick", "openPage('artistPage.php?id=" + song.artist + "')");
			});

			$.post("includes/handlers/ajax/getArtworkJson.php", {albumId : song.album}, function(data){
				var album = JSON.parse(data);
				//console.log(album.artworkPath);
				$(".albumLink img").attr("src", album.artworkPath);
				$(".albumLink img").attr("onclick", "openPage('album.php?id=" + song.album + "')");
				$(".trackName span").attr("onclick", "openPage('album.php?id=" + song.album + "')");
			});

		});


		if(play) {
			playSong();
			//audioElement.play();
			
			//$(".controlButton.play").hide();
			//$(".controlButton.pause").show();
		}	
		else {
			pauseSong();
		}
	}

	function playSong() {
		//audio html element has a currentTime.
		if(audioElement.audio.currentTime == 0) //only update if the song has just started 
		{
			$.post("includes/handlers/ajax/updatePlays.php", {songId : audioElement.currentlyPlaying.id });
		}
		

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();

		audioElement.play();
	}


	function pauseSong() {
		$(".controlButton.play").show();
		$(".controlButton.pause").hide();
		audioElement.pause();
	}

	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;

		//change the image
		if(audioElement.audio.muted) {
			$(".controlButton.volume img").attr("src", "assets/images/icons/volume-mute.png");
		}
		else {
			$(".controlButton.volume img").attr("src", "assets/images/icons/volume.png");
		}
	}


	function setShuffle() {
		shuffle = !shuffle;
		var src = shuffle ? "shuffle-active.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + src);

		if(shuffle) {
			shufflePlaylist = shuffleArray(shufflePlaylist);
			currentSongIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
			//randomize the currentPlaylist
		}
		else {
			//go back to the original playlist(currentPlaylist)
			currentSongIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}

	}

	function shuffleArray(a) {
	    var j, x, i;
	    for (i = a.length - 1; i > 0; i--) {
	        j = Math.floor(Math.random() * (i + 1));
	        x = a[i];
	        a[i] = a[j];
	        a[j] = x;
	    }
	    return a;
}

</script>


<div id="nowPlayingBarContainer">
			
	<div id="nowPlayingBar">
		
		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" onclick="" class="albumArtwork">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0" style="color: #fff;"></span>
					</span>
					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>
				</div>

			</div>
			
		</div>

		<div id="nowPlayingCenter">

			<div class="content playerControls">

				<div class="buttons">
					<button class="controlButton shuffle" title="Shuffle Button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png">
					</button>

					<button class="controlButton previous" title="previous Button" onclick="previousSong()">
						<img src="assets/images/icons/previous.png">
					</button>

					<button class="controlButton play" title="play Button" style="display: none;" onclick="playSong()">
						<img src="assets/images/icons/play.png">
					</button>

					<button class="controlButton pause" title="pause Button" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png">
					</button>

					<button class="controlButton next" title="next Button" onclick="nextSong()">
						<img src="assets/images/icons/next.png">
					</button>

					<button class="controlButton repeat" title="repeat Button" onclick="invertRepeat()">
						<img src="assets/images/icons/repeat.png">
					</button>

				</div>

				<div class="playBackBar">
					
					<span class="progressTime current">0.00</span>
					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>

					</div>
					<span class="progressTime remaining">0.0</span>

				</div>
			
			</div>
		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">
				<button class="controlButton volume" title="volume button">
					<img src="assets/images/icons/volume.png" onclick="setMute()"></img>
				</button>


			<div class="progressBar">
				<div class="progressBarBg">
					<div class="progress"></div>
				</div>

			</div>
		</div>

	</div>
</div>