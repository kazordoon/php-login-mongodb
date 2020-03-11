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

		// SUCCESS
		$database = new Database();
		$users = $database->getCollection();

		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		$users->insertOne([
			'name' => $name,
			'email' => $email,
			'password' => $hashedPassword
		]);
						
		header('Location: login.php');
	}