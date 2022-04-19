<?php 

	//include('includes/header.php');
	include('includes/includedFiles.php')

?>

<h1 class="pageHeadingBig">Albums</h1>
<div class="gridViewContainer">
	
	<?php 

		$albumQuery = mysqli_query($con, 'SELECT * FROM albums');

		while ($row = mysqli_fetch_array($albumQuery)) {
			$title = $row['title'];
			$artworkSrc = $row['artworkPath'];
			$id = $row['id'];

			echo "

				<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=$id\")'>
					
						<img src='$artworkSrc'>
						<div class='gridViewInfo'>
							$title
						</div>
					</span>
				</div>


			";
		}

	?>

</div>

<?php //include('includes/footer.php') ?>