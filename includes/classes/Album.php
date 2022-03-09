<?php

	class Album
	{
		private $con;
		private $id;
		private $title;
		private $genre;
		private $artistId;
		private $artworkPath;

		public function __construct($con, $albumId)
		{
			$this->con = $con;
			$this->id = $albumId;

			$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id = '$albumId'");
			$album = mysqli_fetch_array($albumQuery);

			$this->title = $album['title'];
			$this->genre = $album['genre'];
			$this->artistId = $album['artist'];
			$this->artworkPath = $album['artworkPath'];
		}

		public function getTitle() {
			return $this->title;
		}

		public function getGenre() {
			return $this->genre;
		}

		public function getArtworkPath() {
			return $this->artworkPath;
		}

		public function getArtist() {
			return new Artist($this->con, $this->artistId);
		}

		public function getNumberOfSongs() {
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album = '$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongIdArray(){
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album = '$this->id' ORDER BY albumOrder ASC");

			$songIdArray = array();

			while($row = mysqli_fetch_array($query)){
				array_push($songIdArray, $row['id']);
			}

			return $songIdArray;
		}


	}
?>