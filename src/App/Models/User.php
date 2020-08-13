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

  public static function getCollection() {
    return self::$collection;
  }

  public static function findByEmail(string $email) {
    $user = self::getCollection()->findOne(['email' => $email]);
    return $user;
  }
}

User::loadModel();
