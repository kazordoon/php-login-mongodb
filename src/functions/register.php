<?php
	require_once 'config/Database.php';

	function register($name, $email, $password, $repeatPassword) {
		// Validations
		if (empty($name) && empty($email) && empty($password)) {
			$error = 'Fill in all fields php';
			$_SESSION['error'] = $error;
			return;
		}

		if (strlen($password) < 8) {
			$error = 'Password must have at least 8 characters';
			$_SESSION['error'] = $error;
			return;
		}
		
		if ($password !== $repeatPassword) {
			$error = "Passwords don't match";
			$_SESSION['error'] = $error;
			return;
		}
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = 'Invalid email';
			$_SESSION['error'] = $error;
			return;
		}

		$database = new Database();
		$users = $database->getCollection();

		$user = $users->findOne(['email' => $email]);

		if (!empty($user)) {
			$error = 'This email is already in use';
			$_SESSION['error'] = $error;
			return;
		}

		// SUCCESS

		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		$users->insertOne([
			'name' => $name,
			'email' => $email,
			'password' => $hashedPassword
		]);

		header('Location: login.php');
		exit();
	}
