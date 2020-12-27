<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Validators\UserValidator;

class EmailVerificationController extends Controller {
  public function index() {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $emailVerificationToken = filter_input(INPUT_GET, 'token');

    $isTheEmailFieldEmpty = empty($email);
    if ($isTheEmailFieldEmpty) {
      $_SESSION['error_message'] = 'Preencha o campo de e-mail.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
    if ($isAnInvalidEmail) {
      $_SESSION['error_message'] = 'O e-mail fornecido tem um formato inválido.';
      redirectTo(BASE_URL . 'register');
    }

    $user = User::findByEmail($email);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error_message'] = 'There is no user with the provided email.';
      redirectTo(BASE_URL . 'login');
    }

    $emailAlreadyVerified = $user['verified'];
    if ($emailAlreadyVerified) {
      $_SESSION['error_message'] = 'This email has already been verified before.';
      redirectTo(BASE_URL . 'login');
    }

    $isAnInvalidEmailVerificationToken = $user['emailVerificationToken'] !== $emailVerificationToken;
    if ($isAnInvalidEmailVerificationToken) {
      $_SESSION['error_message'] = 'Invalid token.';
      redirectTo(BASE_URL . 'login');
    }

    User::findByIdAndUpdate($user['_id'], [
      'verified' => true,
      'emailVerificationToken' => null
    ]);

    $_SESSION['success_message'] = 'Your email has been verified.';
    redirectTo(BASE_URL);
  }
}
