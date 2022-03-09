<?php 
	include("includes/includedFiles.php");
?>

<div class="entityInfo">
	<div class="entityyName" style="text-align: center;">
		<h1><?php echo $user->getFirstAndLastName(); ?></h1>
	</div>

	<div class="buttonItems" style="text-align: center;">
		<button class="button" onclick="openPage('updateDetails.php')"> User Details </button><br>
		<button class="button" onclick="logout()"> Logout </button>
	</div>
</div>