<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ResetPasswordController extends Controller {
  public function index() {
    $error = $_SESSION['error'] ?? null;

    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $passwordRecoveryToken = filter_input(INPUT_GET, 'token');

    [$user] = User::findBy(['email' => $email]);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error'] = 'There is no user with the provided email.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $invalidPasswordRecoveryToken = $user['passwordRecoveryToken'] !== $passwordRecoveryToken;
    if ($invalidPasswordRecoveryToken) {
      $_SESSION['error'] = 'Invalid token.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $now = time();
    $passwordRecoveryTokenHasExpired = $user['passwordTokenExpirationTime'] < $now;
    if ($passwordRecoveryTokenHasExpired) {
      $_SESSION['error'] = 'The password recovery token has expired.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $data = [
      'error' => $error
    ];

    if ($error) {
      unset($_SESSION['error']);
    }

    $this->render('reset_password', $data);
  }

  public function reset() {}
}
