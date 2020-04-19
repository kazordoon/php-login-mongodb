<?php
	require_once 'config/Database.php';

	function login($email, $password) {
		if (empty($email) || empty($password)) {
			$error = 'Fill in all fields';
			$_SESSION['error'] = $error;
			return;
		}

		$database = new Database();
		$users = $database->getCollection();

		$user = $users->findOne([
			'email' => $email
		]);

		if (empty($user)) {
			$error = 'User not found';
			$_SESSION['error'] = $error;
			return;
		}

		$userPassword = $user['password'];

		if (!password_verify($password, $userPassword)) {
			$error = 'Incorrect password';
			$_SESSION['error'] = $error;
			return;
		}

		$_SESSION['userId'] = $user['_id'];
		$_SESSION['userName'] = $user['name'];

		header('Location: index.php');
		exit;
	}
