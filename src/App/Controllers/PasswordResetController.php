<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\AccountErrors;
use App\Errors\TokenErrors;
use App\Errors\ValidationErrors;
use App\Models\User;
use App\Validators\UserValidator;

class PasswordResetController extends Controller {
  public function index() {
    $errorMessage = $_SESSION['error_message'] ?? null;

    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $passwordRecoveryToken = filter_input(INPUT_GET, 'token');

    $user = User::findByEmail($email);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error_message'] = AccountErrors::ACCOUNT_NOT_FOUND;
      redirectTo(BASE_URL . 'recover_password');
    }

    $hasAnInvalidPasswordRecoveryToken = $user['passwordRecoveryToken'] !== $passwordRecoveryToken;
    if ($hasAnInvalidPasswordRecoveryToken) {
      $_SESSION['error_message'] = TokenErrors::INVALID_TOKEN;
      redirectTo(BASE_URL . 'recover_password');
    }

    $now = time();
    $passwordRecoveryTokenHasExpired = $user['passwordTokenExpirationTime'] < $now;
    if ($passwordRecoveryTokenHasExpired) {
      $_SESSION['error_message'] = TokenErrors::EXPIRED_TOKEN;
      redirectTo(BASE_URL . 'recover_password');
    }

    $_SESSION['user_id_to_reset_pass'] = $user['_id'];

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    $this->render('reset_password', $data);
  }

  public function reset() {
    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $userId = $_SESSION['user_id_to_reset_pass'] ?? null;

      $password = filter_input(INPUT_POST, 'password');
      $repeatedPassword = filter_input(INPUT_POST, 'repeatedPassword');

      $hasAnInvalidPasswordLength = !UserValidator::hasAValidPasswordLength($password);
      if ($hasAnInvalidPasswordLength) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_PASSWORD_LENGTH;
        redirectTo(BASE_URL . $_SERVER['REQUEST_URI']);
      }

      $passwordsAreDifferent = !UserValidator::areThePasswordsTheSame(
        $password,
        $repeatedPassword
      );
      if ($passwordsAreDifferent) {
        $_SESSION['error_message'] = ValidationErrors::DIFFERENT_PASSWORDS;
        redirectTo(BASE_URL . $_SERVER['REQUEST_URI']);
      }

      $hashedPassword = password_hash($password, PASSWORD_HASH);
      User::findByIdAndUpdate($userId, [
        'password' => $hashedPassword
      ]);

      User::findByIdAndUpdate($userId, [
        'passwordRecoveryToken' => null,
        'passwordTokenExpirationTime' => null
      ]);

      unset($_SESSION['user_id']);

      $_SESSION['success_message'] = 'Your password has been updated.';
      redirectTo(BASE_URL);
    }
  }
}
