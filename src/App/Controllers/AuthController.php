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
        $error = 'Fill in all fields';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      $userModel = new User;
      [$user] = $userModel->findBy(['email' => $email]);

      if (empty($user)) {
        $error = 'User not found';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      if (!password_verify($password, $user['password'])) {
        $error = 'Incorrect password';
        $_SESSION['error'] = $error;
        header('Location: ' . BASE_URL . 'login');
        exit;
      }

      $_SESSION['userId'] = $user['_id'];

      header('Location: ' . BASE_URL);
      exit;
    }
  }
}
