<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use PHPMailer\PHPMailer\Exception;

class EmailCheckSendingController extends Controller {
  public function index() {
    $email = filter_input(INPUT_GET, 'email');

    if (!$email) {
      redirectTo(BASE_URL . 'login');
    }

    $foundUser = User::findByEmail($email);

    $userNotFound = !$foundUser;
    if ($userNotFound) {
      redirectTo(BASE_URL . 'login');
    }

    $hasTheEmailAlreadyVerified = $foundUser['verified'];
    if ($hasTheEmailAlreadyVerified) {
      redirectTo(BASE_URL . 'login');
    }

    $user = new User;
    $user->name = $foundUser['name'];
    $user->email = $email;
    $emailVerificationToken = generateToken();

    User::findByIdAndUpdate($foundUser['_id'], [
      'emailVerificationToken' => $emailVerificationToken
    ]);

    try {
      sendEmailVerificationLink($user, $emailVerificationToken);
    } catch (Exception $e) {
      $_SESSION['error'] = 'Could not to send an email verification link via email, try again.';
      redirectTo(BASE_URL . 'login');
    }

    $data = [
      'email' => $email
    ];
    $this->render('send_verification_email', $data);
  }
}
