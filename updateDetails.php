<?php include("includes/includedFiles.php") ?>

<div class="userDetails">

	<div class="container" style="border-bottom: 3px solid #fff;">
		<h2>Email</h2>
		<input type="text" class="email" name="email" placeholder="Your Email Here" value="<?php echo $user->getEmail(); ?>">
		<span class="message emailMessage"></span>
		<button class="button" onclick="updateEmail()">Update Email</button>
	</div>

	<div class="container">

		<h2>Password</h2>
		<input type="password" name="currentPw" placeholder="Current Password">
		<input type="password" name="newPw" placeholder="New Password">
		<input type="password" name="confirmPw" placeholder="Confirm Password">
		<span class="message passwordMessage"></span>
		<button class="button" onclick="updatePassword()">Update Password</button>
		
	</div>
	
</div>