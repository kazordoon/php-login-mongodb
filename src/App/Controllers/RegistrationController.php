<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class RegistrationController extends Controller {
  public function index() {
    $isTheUserLoggedIn = isset($_SESSION['userId']);

    if ($isTheUserLoggedIn) {
      header('Location: ' . BASE_URL);
      exit;
    }

    $error = $_SESSION['error'] ?? null;

    $data = [
      'error' => $error
    ];

    if ($error) {
      unset($_SESSION['error']);
    }

    return $this->render('register', $data);
  }

  public function store() {
    if (isset($_POST['btn-register'])) {
      $name = htmlentities($_POST['name']);
      $email = htmlentities($_POST['email']);
      $password = htmlentities($_POST['password']);
      $repeatPassword = htmlentities($_POST['repeatPassword']);

      // Validations
      if (empty($name) && empty($email) && empty($password)) {
        $error = 'Fill in all fields php';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      if (strlen($password) < 8) {
        $error = 'Password must have at least 8 characters';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      if ($password !== $repeatPassword) {
        $error = "Passwords don't match";
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      $user = User::findBy(['email' => $email]);

      if (!empty($user)) {
        $error = 'This email is already in use';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      // SUCCESS

      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      User::create([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword
      ]);

      header('Location: ' . BASE_URL);
      exit();
    }
  }
}
