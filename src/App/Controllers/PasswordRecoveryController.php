<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Providers\Mail;
use PHPMailer\PHPMailer\Exception;

class PasswordRecoveryController extends Controller {
  public function index() {
    $isTheUserLoggedIn = isset($_SESSION['userId']);

    if ($isTheUserLoggedIn) {
      redirectTo(BASE_URL);
    }

    $errorMessage = $_SESSION['error_message'] ?? null;
    $successMessage = $_SESSION['success_message'] ?? null;

    $csrfToken = generateToken();
    $_SESSION['csrf_token'] = $csrfToken;

    $data = [
      'error_message' => $errorMessage,
      'success_message' => $successMessage,
      'csrf_token' => $csrfToken
    ];

    clearSessionMessages();

    return $this->render('recover_password', $data);
  }

  public function sendRecoveryToken() {
    $isAValidCSRFToken = $_POST['_csrf'] === $_SESSION['csrf_token'];
    if ($isAValidCSRFToken) {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

      $isTheEmailFieldEmpty = empty($email);
      if ($isTheEmailFieldEmpty) {
        $_SESSION['error_message'] = 'Fill in the email field.';
        redirectTo(BASE_URL . 'recover_password');
      }

      $user = User::findByEmail($email);

      $userNotFound = !$user;
      if ($userNotFound) {
        $_SESSION['error_message'] = 'There is no user with the provided email.';
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
        $_SESSION['success_message'] = 'An email message with the password recovery link has been sent to your email.';
      } catch (Exception $e) {
        $_SESSION['error_message'] = 'Could not to send a password recovery link via email, try again.';
      }

      redirectTo(BASE_URL . 'recover_password');
    }
  }
}
