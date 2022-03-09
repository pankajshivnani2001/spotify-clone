<div id="navBarContainer">

	<nav class="navBar">

		<span role="link" tabindex="0" onclick="openPage('index.php')">
			<img src="assets/images/spotify.png">
		</span>

		<div class="group">
			
			
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('search.php')">Search</span>
					<img src="assets/images/icons/search.png">
				
			</div>

		</div>

		<div class="group">

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('browse.php')">Browse</span>
			</div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('yourMusic.php')">Your Music</span>
			</div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('settings.php')"> <?php echo $user->getFirstAndLastName(); ?> </span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" onclick="logout()"> Logout </span>
			</div>

			<div class="navItem">
				<button class="button" style="margin-top: 30px; font-size: 15px;" onclick="openPage('upgradePlan.php')">Upgrade</button>
			</div>

		</div>

	</nav>
</div>