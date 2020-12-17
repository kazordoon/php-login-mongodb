<?php

namespace App\Controllers;

use App\Core\Controller;

class LogOutController extends Controller {
  public function index() {
    $isTheUserLoggedIn = $_SESSION['userId'] ?? null;

    if ($isTheUserLoggedIn) {
      session_destroy();
    }

    redirectTo(BASE_URL . 'login');
  }
}
