<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Errors\AccountErrors;
use App\Errors\ValidationErrors;
use App\Models\User;
use App\Validators\UserValidator;

class RegistrationController extends Controller {
  public function index() {
    $isTheUserLoggedIn = isset($_SESSION['user_id']);

    if ($isTheUserLoggedIn) {
      redirectTo(BASE_URL);
    }

    $errorMessage = $_SESSION['error_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'error_message' => $errorMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    return $this->render('register', $data);
  }

  public function store() {
    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $name = filter_input(INPUT_POST, 'name');
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $password = filter_input(INPUT_POST, 'password');
      $repeatedPassword = filter_input(INPUT_POST, 'repeatedPassword');

      $areTheFieldsEmpty = empty($name) || empty($email) || empty($password);
      if ($areTheFieldsEmpty) {
        $_SESSION['error_message'] = ValidationErrors::EMPTY_FIELDS;
        redirectTo(BASE_URL . 'register');
      }

      $hasAnInvalidNameLength = !UserValidator::hasAValidNameLength($name);
      if ($hasAnInvalidNameLength) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_NAME_LENGTH;
        redirectTo(BASE_URL . 'register');
      }

      $hasAnInvalidPasswordLength = !UserValidator::hasAValidPasswordLength($password);
      if ($hasAnInvalidPasswordLength) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_PASSWORD_LENGTH;
        redirectTo(BASE_URL . 'register');
      }

      $passwordsAreDifferent = !UserValidator::areThePasswordsTheSame(
        $password,
        $repeatedPassword
      );
      if ($passwordsAreDifferent) {
        $_SESSION['error_message'] = ValidationErrors::DIFFERENT_PASSWORDS;
        redirectTo(BASE_URL . 'register');
      }

      $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
      if ($isAnInvalidEmail) {
        $_SESSION['error_message'] = ValidationErrors::INVALID_EMAIL_FORMAT;
        redirectTo(BASE_URL . 'register');
      }

      $user = User::findByEmail($email);

      $userAlreadyExists = !empty($user);
      if ($userAlreadyExists) {
        $_SESSION['error_message'] = AccountErrors::EMAIL_ALREADY_IN_USE;
        redirectTo(BASE_URL . 'register');
      }

      $emailVerificationToken = generateToken();
      $hashedPassword = password_hash($password, PASSWORD_HASH);
      User::create([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'verified' => false,
        'emailVerificationToken' => $emailVerificationToken
      ]);

      $emailVerificationPage = BASE_URL . "send_verification_email?email={$email}";
      redirectTo($emailVerificationPage);
    }
  }
}
