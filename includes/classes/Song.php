<?php

	class Song
	{
		private $con;
		private $id;
		private $mysqliData;
		private $title;
		private $artistId;
		private $albumId;
		private $genreId;
		private $duration;
		private $path;

		function __construct($con, $songId)
		{
			$this->con = $con;
			$this->id = $songId;

			$query = mysqli_query($this->con, "SELECT * FROM songs WHERE id = '$this->id'");
			$this->mysqliData = mysqli_fetch_array($query);

			$this->title = $this->mysqliData['title'];
			$this->artistId = $this->mysqliData['artist'];
			$this->albumId = $this->mysqliData['album'];
			$this->genreId = $this->mysqliData['genre'];
			$this->duration = $this->mysqliData['duration'];
			$this->path = $this->mysqliData['path'];
		}

		public function getTitle(){
			return $this->title;
		}


		public function getDuration(){
			return $this->duration;
		}


		public function getPath(){
			return $this->path;
		}


		public function getGenre(){
			return $this->genre;
		}


		public function getArtist(){
			return new Artist($this->con, $this->artistId);
		}


		public function getAlbum(){
			return new Album($this->con, $this->albumId);
		}

		public function getMysqliData(){
			return $this->mysqliData;
		}
	}
?>