<?php

namespace App\Models;

use App\Core\Model;
use MongoDB\Client as MongoClient;

class User extends Model {
  protected string $collectionName = 'users';
  public string $id;
  public string $name;
  public string $email;
  public string $password;

  public function __construct() {
    parent::__construct(new MongoClient(MONGODB_URI));
  }

  public function getCollection() {
    return $this->collection;
  }
}
