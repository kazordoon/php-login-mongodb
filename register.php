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
				<input type="password" name="repeat_password" id="repeatPassword" aria-label="repeatPassword" placeholder="Repeat password" minlength="8" required />
			</div>

			<button name="btn-register">Register</button>
			<p><small>Already have an account ? <a href="/login.php">Log in</a></small></p>
		</form>

		<?php
			if (isset($_POST['btn-register'])) {
				$name = htmlentities($_POST['name']);
				$email = htmlentities($_POST['email']);
				$password = htmlentities($_POST['password']);

				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

				echo "<p>Name: $name</p>";
				echo "<p>E-mail: $email</p>";
			}
		?>
	</div>

	<script src="public/js/utils/validateEmail"></script>
	<script src="public/js/utils/generateError"></script>
	<script src="public/js/register.js"></script>
</body>
</html>