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

    return $this->render('recover_password', $data);
  }

  public function sendRecoveryToken() {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $isTheEmailFieldEmpty = empty($email);
    if ($isTheEmailFieldEmpty) {
      $_SESSION['error'] = 'Fill in the email field.';
      redirectTo(BASE_URL . 'recover_password');
    }

    [$user] = User::findBy(['email' => $email]);

    $userNotFound = !$user;
    if ($userNotFound) {
      $_SESSION['error'] = 'There is no user with the provided email.';
      redirectTo(BASE_URL . 'recover_password');
    }

    $passwordRecoveryToken = uniqid(bin2hex(random_bytes(32)));
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
    } catch (Exception $e) {
      $_SESSION['error'] = 'Could not to send a password recovery link via email, try again.';
      redirectTo(BASE_URL . 'recover_password');
    }
  }
}
