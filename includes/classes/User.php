<?php 

	class User {
		private $con;
		private $name;//username

		public function __construct($con, $username)
		{
			$this->con = $con;
			$this->name = $username;
		}

		public function getName(){
			return $this->name;
		}


		public function getPlaylists()
		{
			$query = mysqli_query($this->con, "SELECT * FROM playlists WHERE owner = '$this->name'");

			return $query;
		}

		public function getFirstAndLastName()
		{
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as name FROM users WHERE username = '$this->name'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}

		public function getEmail()
		{
			$query = mysqli_query($this->con, "SELECT email FROM users WHERE username = '$this->name'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}
	}

?>