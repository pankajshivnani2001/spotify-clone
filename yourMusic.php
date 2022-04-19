<?php 

	include("includes/includedFiles.php");

?>


<div class="playlistsContainer" style="padding: 10px">
	
	<div class="gridViewContainer">
		
		<h2>PLAYLISTS</h2>

		<div class="buttonItems">
			<button class="button green" style="display: block; margin: 0 auto 10px auto;" onclick="createPlaylist()"> 
				Add New Playlist 
			</button>
		</div>
			

			<?php 

				$queryResult = $user->getPlaylists();

				if(mysqli_num_rows($queryResult) == 0)
					echo "<span class='noResults'> You don't have any playlists yet! </span>";

				while($row = mysqli_fetch_array($queryResult))
				{
					$playlist = new Playlist($con ,$row['id']);
					$playlistName = $playlist->getPlaylistName();
					echo "

						<div class='gridViewItem' role='link' tabindex=0 onclick='openPage(\"playlist.php?id=". $playlist->getId() ."\")'>
							
								<div class='playlistImage'>
									<img src='assets/images/icons/playlist.png'>
								</div>
							
								<div class='gridViewInfo'>
									$playlistName
								</div>
							
						</div>


					";
				}
			?>

	</div>

</div>