<?php
	session_start();

	require_once 'config/database.php';
	require_once 'generateError.php';

	function login($email, $password) {
		if (empty($email) || empty($password)) {
			$error = 'Fill in all fields';
			generateError($error);
			return;
		}

		$database = new Database();
		$users = $database->getCollection();

		$user = $users->findOne([
			'email' => $email
		]);

		if (empty($user)) {
			$error = 'User not found';
			generateError($error);
			return;
		}

		$userPassword = $user['password'];

		if (!password_verify($password, $userPassword)) {
			$error = 'Incorrect password';
			generateError($error);
			return;
		}

		$_SESSION['userId'] = $user['_id'];
		$_SESSION['userName'] = $user['name'];

		header('Location: index.php');
	}