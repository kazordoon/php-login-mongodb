<?php

namespace App\Models;

use App\Core\Model;
use MongoDB\Client as MongoClient;

class User extends Model {
  public string $id;
  public string $name;
  public string $email;
  public string $password;
  public int $passwordTokenExpirationTime;
  public string $passwordRecoveryToken;

  public static function loadModel() {
    $collectionName = 'users';
    $client = new MongoClient(MONGODB_URI);
    parent::loadClient($client, $collectionName);
  }

  public function getCollection() {
    return $this->collection;
  }
}

User::loadModel();
