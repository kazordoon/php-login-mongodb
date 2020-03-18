<?php
	require_once 'config/database.php';
	require_once 'generateError.php';

	function register($name, $email, $password, $repeatPassword) {
		if (empty($name) && empty($email) && empty($password)) {
			$error = 'Fill in all fields php';
			generateError($error);
			return;
		}

		if (strlen($password) < 8) {
			$error = 'Password must have at least 8 characters';
			generateError($error);
			return;
		}
		
		if ($password !== $repeatPassword) {
			$error = "Passwords don't match";
			generateError($error);
			return;
		}
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = 'Invalid email';
			generateError($error);
			return;
		}

		$database = new Database();
		$users = $database->getCollection();

		$user = $users->findOne(['email' => $email]);

		if (!empty($user)) {
			$error = 'This email is already in use';
			generateError($error);
			return;
		}

		// SUCCESS

		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		$users->insertOne([
			'name' => $name,
			'email' => $email,
			'password' => $hashedPassword
		]);

		echo "<script>location.href='login.php'</script>";
	}
