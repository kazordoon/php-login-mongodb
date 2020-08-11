<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Validators\UserValidator;

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

      $areTheFieldsEmpty = empty($name) && empty($email) && empty($password);
      if ($areTheFieldsEmpty) {
        $_SESSION['error'] = 'Fill in all fields.';
        redirectTo(BASE_URL . 'register');
      }

      $hasAnInvalidPasswordLength = UserValidator::hasAValidPasswordLength($password);
      if ($hasAnInvalidPasswordLength) {
        $_SESSION['error'] = 'The password must have between 8 and 50 characters.';
        redirectTo(BASE_URL . 'register');
      }

      $passwordsAreDifferent = !UserValidator::areThePasswordsTheSame(
        $password,
        $repeatPassword
      );
      if ($passwordsAreDifferent) {
        $_SESSION['error'] = "The passwords don't match.";
        redirectTo(BASE_URL . 'register');
      }

      $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
      if ($isAnInvalidEmail) {
        $_SESSION['error'] = 'The provided email has an invalid format.';
        redirectTo(BASE_URL . 'register');
      }

      $user = User::findBy(['email' => $email]);

      $userAlreadyExists = !empty($user);
      if ($userAlreadyExists) {
        $_SESSION['error'] = 'This email is already in use.';
        redirectTo(BASE_URL . 'register');
      }


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
