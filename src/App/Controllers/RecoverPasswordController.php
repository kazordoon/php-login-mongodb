<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Providers\Mail;
use PHPMailer\PHPMailer\Exception;

class RecoverPasswordController extends Controller {
  public function index() {
    $isTheUserLoggedIn = isset($_SESSION['userId']);

    if ($isTheUserLoggedIn) {
      redirectTo(BASE_URL);
    }

    $error = $_SESSION['error'] ?? null;
    $success = $_SESSION['success'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrfToken'] = $csrfToken;

    $data = [
      'error' => $error,
      'success' => $success,
      'csrfToken' => $csrfToken
    ];

    clearSessionMessages();

    return $this->render('recover_password', $data);
  }

  public function sendRecoveryToken() {
    $validCsrfToken = $_POST['_csrf'] === $_SESSION['csrfToken'];
    if ($validCsrfToken) {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

      $isTheEmailFieldEmpty = empty($email);
      if ($isTheEmailFieldEmpty) {
        $_SESSION['error'] = 'Fill in the email field.';
        redirectTo(BASE_URL . 'recover_password');
      }

      $user = User::findByEmail($email);

      $userNotFound = !$user;
      if ($userNotFound) {
        $_SESSION['error'] = 'There is no user with the provided email.';
        redirectTo(BASE_URL . 'recover_password');
      }

      $passwordRecoveryToken = generateToken();
      $oneHour = time() + 3600;
      $passwordTokenExpirationTime = $oneHour;

      User::findByIdAndUpdate($user['_id'], [
        'passwordRecoveryToken' => $passwordRecoveryToken,
        'passwordTokenExpirationTime' => $passwordTokenExpirationTime
      ]);

      $passwordRecoveryLink = BASE_URL . "reset_password?email={$email}&token={$passwordRecoveryToken}";
      $mailMessageContent = "Forgot your password ? Use this link to recover it: {$passwordRecoveryLink}";
      $mail = new Mail;
      $mail->setRecipient($email, $user['name']);
      $mail->writeContent('Recover password', $mailMessageContent);

      try {
        $mail->send();
        $_SESSION['success'] = 'An email message with the password recovery link has been sent to your email.';
      } catch (Exception $e) {
        $_SESSION['error'] = 'Could not to send a password recovery link via email, try again.';
      }

      redirectTo(BASE_URL . 'recover_password');
    }
  }
}
