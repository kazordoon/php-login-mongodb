<?php

namespace App\Core;

use MongoDB\Client as MongoClient;
use MongoDB\Collection;
use MongoDB\BSON\ObjectId;

abstract class Model {
  protected static Collection $collection;

  public static function loadClient(MongoClient $mongoClient, string $collectionName) {
    $dbName = DB_NAME;
    $db = $mongoClient->$dbName;
    self::$collection = $db->$collectionName;
  }

  public static function findById(string $id) {
    $document = self::$collection->findOne(['_id' => new ObjectId($id)]);
    return $document;
  }

  public static function findBy(array $filter) {
    $documents = [];
    $query = self::$collection->find($filter);

    foreach ($query as $document) {
      $documents[] = $document;
    }

    return $documents;
  }

  public static function create(array $fields) {
    $data = self::$collection->insertOne($fields);

    return $data->getInsertedId();
  }
}
