<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Login</title>
	<link rel="stylesheet" href="public/css/styles.css" />
</head>
<body>

	<?php
			if (isset($_POST['btn-register'])) {
				require_once 'functions/login.php';

				$email = $_POST['email'];
				$password = $_POST['password'];

				login($email, $password);
			}
		?>

	<div class="container">
	<h1>Login</h1>
		<form method="POST" action="" name="form-login">
			<div class="form-group">
				<label for="email"></label>
				<input type="email" name="email" id="email" aria-label="email" placeholder="E-mail" required />
			</div>
			<div class="form-group">
				<label for="password"></label>
				<input type="password" name="password" id="password" aria-label="password" placeholder="Password" required />
			</div>

			<button name="btn-register">Log In</button>
			<p><small>Don't have an account ? <a href="register.php">Sign up</a></small></p>
		</form>
		</div>

	<script src="public/js/utils/generateError"></script>
	<script src="public/js/login.js"></script>
	<noscript><meta http-equiv="refresh" content="0; url=noscript.html"></noscript>
</body>
</html>