<?php 
		
	class Discover 
	{
		private $con;

		function __construct($con)
		{
			$this->con = $con;
		}

		function getTotalSongs()
		{
			$query = mysqli_query($this->con, "SELECT COUNT(*) as total FROM songs");
			$res = mysqli_fetch_array($query);
			return $res['total'];
		}

		function getTotalAlbums()
		{
			$query = mysqli_query($this->con, "SELECT COUNT(*) as total FROM albums");
			$res = mysqli_fetch_array($query);
			return $res['total'];
		}

		function getTotalGenres() 
		{
			$query = mysqli_query($this->con, "SELECT COUNT(*) as total FROM genres");
			$res = mysqli_fetch_array($query);
			return $res['total'];
		}

		function getTotalArtists() 
		{
			$query = mysqli_query($this->con, "SELECT COUNT(*) as total FROM artists");
			$res = mysqli_fetch_array($query);
			return $res['total'];
		}

		function getAllSongs() 
		{
			$query = mysqli_query($this->con, "SELECT id FROM songs");
			$songIdArray = array();

			while($row = mysqli_fetch_array($query)){
				array_push($songIdArray, $row['id']);
			}

			return $songIdArray;
			
		}

		function getSongsSortedByPlays() 
		{
			$query = mysqli_query($this->con, "SELECT id FROM songs ORDER BY plays DESC");
			$songIdArray = array();

			while($row = mysqli_fetch_array($query)){
				array_push($songIdArray, $row['id']);
			}

			return $songIdArray;
			
		}

		function getSongsSortedByDuration() 
		{
			$query = mysqli_query($this->con, "SELECT id FROM songs ORDER BY duration DESC");
			$songIdArray = array();

			while($row = mysqli_fetch_array($query)){
				array_push($songIdArray, $row['id']);
			}

			return $songIdArray;
			
		}



	}

?>