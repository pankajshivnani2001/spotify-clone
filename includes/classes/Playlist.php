<?php 

	class Playlist
	{
		private $con;
		private $id;
		private $playlistName;
		private $owner;
		private $dateCreated;

		function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;

			$query = mysqli_query($con, "SELECT * FROM playlists WHERE id = '$id'");
			$row = mysqli_fetch_array($query);

			$this->playlistName = $row['name'];
			$this->owner = $row['owner'];
			$this->dateCreated = $row['dateCreated'];
		}

		public function getId() {
			return $this->id;
		}

		function getPlaylistName() {
			return $this->playlistName;
		}

		function getOwner() {
			return $this->owner;
		}

		function getDateCreated() {
			return $this->dateCreated;
		}

		function getNumberOfSongs() {
			$query = mysqli_query($this->con, "SELECT * FROM playlistSongs WHERE playlistId = '$this->id'");
			return mysqli_num_rows($query);
		}

		function getSongIdArray() {
			$query = mysqli_query($this->con, "SELECT * FROM playlistSongs WHERE playlistId = '$this->id' ORDER BY playlistOrder");
			$songIdArray = array();

			while($row = mysqli_fetch_array($query))
			{
				array_push($songIdArray, $row['songId']);
			}

			return $songIdArray;
		}

	}

?>