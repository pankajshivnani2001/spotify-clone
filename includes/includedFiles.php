<?php
	
	//This php file will check if a page is loaded using AJAX or by manually entering the URL. For AJAX calls, we don't want
	//to include the header and footer and other files twice.

	//AJAX calls are always sent using HTTP_X_REQUESTED_WITH
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])){
		include('includes/config.php');
		include('includes/classes/User.php');
		include('includes/classes/Artist.php');
		include('includes/classes/Album.php');
		include('includes/classes/Song.php');
		include('includes/classes/Playlist.php');

		if(isset($_GET['userLoggedIn'])) {
			$user = new User($con, $_GET['userLoggedIn']);

		}

	}

	else {

		
		include('includes/header.php');
		include('includes/footer.php');

		$url = $_SERVER['REQUEST_URI'];
		echo "<script> openPage('$url') </script>";
		exit();//to exit because openPage() makes an AJAX call and it will bring us back to the includedFiles.php(this file) and will execute the if() statement.
	}
	
?>