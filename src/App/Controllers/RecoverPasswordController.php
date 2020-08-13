<?php

namespace App\Controllers;

use App\Core\Controller;

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

  public function sendRecoveryToken() {}
}
