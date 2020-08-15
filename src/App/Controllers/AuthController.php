<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
  public function index() {
    $isTheUserLoggedIn = isset($_SESSION['userId']);
    $success = $_SESSION['success'] ?? null;

    if ($isTheUserLoggedIn) {
      header('Location: ' . BASE_URL);
      exit;
    }

    $error = $_SESSION['error'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrfToken'] = $csrfToken;

    $data = [
      'success' => $success,
      'error' => $error,
      'csrfToken' => $csrfToken
    ];

    clearSessionMessages();

    return $this->render('login', $data);
  }

  public function auth() {
    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrfToken'];
    if ($isAValidCSRFToken) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $areTheFieldsEmpty = empty($email) || empty($password);
      if ($areTheFieldsEmpty) {
        $_SESSION['error'] = 'Fill in all fields';
        redirectTo(BASE_URL . 'login');
      }

      $user = User::findByEmail($email);

      $userNotFound = empty($user);
      if ($userNotFound) {
        $_SESSION['error'] = 'User not found';
        redirectTo(BASE_URL . 'login');
      }

      $isThePasswordIncorrect = !password_verify($password, $user['password']);
      if ($isThePasswordIncorrect) {
        $_SESSION['error'] = 'Incorrect password';
        redirectTo(BASE_URL . 'login');
      }

      $_SESSION['userId'] = $user['_id'];

      redirectTo(BASE_URL);
    }
  }
}
