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

      // Validations
      if (empty($name) && empty($email) && empty($password)) {
        $_SESSION['error'] = 'Fill in all fields php';;
        redirectTo(BASE_URL . 'login');
      }

      $hasAnInvalidPasswordLength = UserValidator::hasAValidPasswordLength($password);
      if ($hasAnInvalidPasswordLength) {
        $_SESSION['error'] = 'Password must have at least 8 characters';;
        redirectTo(BASE_URL . 'login');
      }

      $passwordsAreDifferent = !UserValidator::areThePasswordsTheSame(
        $password,
        $repeatPassword
      );
      if ($passwordsAreDifferent) {
        $_SESSION['error'] = "Passwords don't match";
        redirectTo(BASE_URL . 'login');
      }

      $isAnInvalidEmail = !UserValidator::isAValidEmail($email);
      if ($isAnInvalidEmail) {
        $_SESSION['error'] = 'Invalid email';;
        redirectTo(BASE_URL . 'login');
      }

      $user = User::findBy(['email' => $email]);

      if (!empty($user)) {
        $_SESSION['error'] = 'This email is already in use.';
        redirectTo(BASE_URL . 'login');
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
