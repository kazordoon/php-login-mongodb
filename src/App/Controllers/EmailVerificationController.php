<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class EmailVerificationController extends Controller {
  public function index() {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $emailVerificationToken = filter_input(INPUT_GET, 'token');

    $user = User::findByEmail($email);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error'] = 'There is no user with the provided email.';
      redirectTo(BASE_URL . 'login');
    }

    $invalidEmailVerificationToken = $user['emailVerificationToken'] !== $emailVerificationToken;
    if ($invalidEmailVerificationToken) {
      $_SESSION['error'] = 'Invalid token.';
      redirectTo(BASE_URL . 'login');
    }

    User::findByIdAndUpdate($user['_id'], [
      'verified' => true,
      'emailVerificationToken' => null
    ]);

    $_SESSION['success'] = 'Your email has been verified.';
    redirectTo(BASE_URL);
  }
}
