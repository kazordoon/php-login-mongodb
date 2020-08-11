<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
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

    return $this->render('login', $data);
  }

  public function auth() {
    if (isset($_POST['btn-login'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Fill in all fields';
        redirectTo(BASE_URL . 'login');
      }

      [$user] = User::findBy(['email' => $email]);

      if (empty($user)) {
        $_SESSION['error'] = 'User not found';
        redirectTo(BASE_URL . 'login');
      }

      if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Incorrect password';
        redirectTo(BASE_URL . 'login');
      }

      $_SESSION['userId'] = $user['_id'];

      header('Location: ' . BASE_URL);
      exit;
    }
  }
}
