<?php
	class Artist
		{
				private $con;
				private $id;
		
				public function __construct($con, $id) {
					$this->con = $con;
					$this->id = $id;
				}
				
				public function getId(){
					return $this->id;
				}

				public function getName(){
					$artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id = '$this->id'");
					$artist = mysqli_fetch_array($artistQuery);
					return $artist['name'];
				}

				public function getSongs(){
					$query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist = '$this->id' ORDER BY plays DESC");
					$songIdArray = array();

					while($row = mysqli_fetch_array($query)){
						array_push($songIdArray, $row['id']);
					}

					return $songIdArray;
				}

				public function getNumberOfAlbums(){
					$query = mysqli_query($this->con, "SELECT count(*) AS total FROM albums WHERE artist = '$this->id'");
					$row = mysqli_fetch_array($query);
					return $row['total'];
				}

				public function getProfilePic(){
					$query = mysqli_query($this->con, "SELECT profilePicPath FROM artists WHERE id = '$this->id'");
					$row = mysqli_fetch_array($query);
					return $row['profilePicPath'];
				}
		}
?>