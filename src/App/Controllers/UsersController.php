<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UsersController extends Controller {
  public function index() {
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
      redirectTo(BASE_URL . 'login');
    }

    $user = User::findById($userId);

    $data = [
      'user' => [
        'id' => $user['_id'],
        'name' => $user['name']
      ]
    ];
    $this->render('index', $data);
  }
}
