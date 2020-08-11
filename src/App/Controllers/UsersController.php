<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use MongoDB\Client;

class UsersController extends Controller {
  public function index() {

    $userId = $_SESSION['userId'] ?? null;

    if (!$userId) {
      header('Location: ' . BASE_URL . 'login');
      exit;
    }

    $user = new User;
    $user = $user->findById($userId);

    $data = [
      'user' => [
        'id' => $user['_id'],
        'name' => $user['name']
      ]
    ];
    $this->render('index', $data);
  }
}
