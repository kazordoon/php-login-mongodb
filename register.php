<?php
	session_start();
	if (isset($_SESSION['userId'])) {
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Register</title>
	<link rel="stylesheet" href="public/css/styles.css" />
</head>
<body>
	<?php
		if (isset($_POST['btn-register'])) {
			require_once 'functions/register.php';

			$name = htmlentities($_POST['name']);
			$email = htmlentities($_POST['email']);
			$password = htmlentities($_POST['password']);
			$repeatPassword = htmlentities($_POST['repeatPassword']);

			register($name, $email, $password, $repeatPassword);
		}
	?>

	<div class="container">
	<h1>Register</h1>
		<form method="POST" action="" name="form-register">
			<div class="form-group">
				<label for="name"></label>
				<input type="name" name="name" id="name" aria-label="name" placeholder="Name" required />
			</div>
			<div class="form-group">
				<label for="email"></label>
				<input type="email" name="email" id="email" aria-label="email" placeholder="E-mail" required />
			</div>
			<div class="form-group">
				<label for="password"></label>
				<input type="password" name="password" id="password" aria-label="password" placeholder="Password" minlength="8" required />
			</div>
			<div class="form-group">
				<label for="repeatPassword"></label>
				<input type="password" name="repeatPassword" id="repeatPassword" aria-label="repeatPassword" placeholder="Repeat password" minlength="8" required />
			</div>

			<button name="btn-register">Register</button>
			<p><small>Already have an account ? <a href="login.php">Log in</a></small></p>
		</form>
	</div>

	<script src="public/js/utils/validateEmail"></script>
	<script src="public/js/utils/generateError"></script>
	<script src="public/js/register.js"></script>
	<noscript><meta http-equiv="refresh" content="0; url=noscript.html"></noscript>
</body>
</html>