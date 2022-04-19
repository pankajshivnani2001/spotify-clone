<?php
	class Genre
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

				public function getGenreName(){
					$genreQuery = mysqli_query($this->con, "SELECT name FROM genres WHERE id = '$this->id'");
					$genre = mysqli_fetch_array($genreQuery);
					return $genre['name'];
				}

				public function getGenreSongs(){
					$query = mysqli_query($this->con, "SELECT id FROM songs WHERE genre = '$this->id'");
					$songIdArray = array();

					while($row = mysqli_fetch_array($query)){
						array_push($songIdArray, $row['id']);
					}

					return $songIdArray;
				}

				public function getGenreImage(){
					$query = mysqli_query($this->con, "SELECT genreImage FROM genres WHERE id = '$this->id'");
					$row = mysqli_fetch_array($query);

					return $row["genreImage"];
				}

				
		}
?>