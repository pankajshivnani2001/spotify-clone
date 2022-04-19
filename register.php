<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");
	$account = new Account($con);
	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name]))
			echo $_POST[$name];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Register Page</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
	<?php

		if(isset($_POST['registerButton'])){
			echo '<script>

			$(document).ready(function() {
						$("#loginForm").hide();
						$("#registerForm").show();
					});

					</script>'
							;
		}

		else{
			echo 
			'<script>

			$(document).ready(function() {
						$("#loginForm").show();
						$("#registerForm").hide();
					});
			</script>'
							;
		}

	?>

	<div id="background">
		<!-- Image and text -->
	

		<div id="loginContainer">

			<div id="inputContainer">
				
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login To Your Account</h2>
					<p>
						<?php echo $account->getError(Constants::$invalidLogin); ?>
						<label for="loginUsername">Username</label>
						<input type="text" name="loginUsername" id="loginUsername" required  value="<?php getInputValue('loginUsername') ?>">
					</p>

					<p>
						<label for="loginPassword">Password</label>
						<input type="password" name="loginPassword" id="loginPassword" required>
					</p>
					
					<button type="submit" name="loginButton">Log In</button>

					<div class="hasAccountText">
						<span id="hideLogin">New User? Sign Up Here</span>
					</div>
				</form>


				<form id="registerForm" action="register.php" method="POST">
					<h2>Sign Up for a Free Account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?php getInputValue('username') ?>"  required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
						<label for="firstname">First Name</label>
						<input type="text" name="firstname" id="firstname" value="<?php getInputValue('firstname') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<label for="lastName">Last Name</label>
						<input type="text" name="lastName" id="lastName" value="<?php getInputValue('lastName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input type="email" name="email" id="email" value="<?php getInputValue('email') ?>" required>
					</p>

					<p>
						<label for="email2">Confirm Email</label>
						<input type="email" name="email2" id="email2" value="<?php getInputValue('email2') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>
						<input type="password" name="password" id="password" required>
					</p>

					<p>
						<label for="password2">Confirm Password</label>
						<input type="password" name="password2" id="password2" required>
					</p>
					
					<button type="submit" name="registerButton">Sign Up</button>

					<div class="hasAccountText">
						<span id="hideRegister">Existing User? Sign In Here</span>
					</div>
				</form>
			</div>

			<div id="loginText">
				<h1>Great Music!! On Your Fingertips</h1>
				<h2>Listen to Loads of Music...</h1>
				<ul>
					<li>Discover Music</li>
					<li>Create Playlists</li>
					<li>Follow Artists</li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>