<?php

namespace App\Core;

use MongoDB\Client as MongoClient;
use MongoDB\Collection;
use MongoDB\BSON\ObjectId;

abstract class Model {
  protected Collection $collection;
  protected string $collectionName;

  public function __construct(MongoClient $mongoClient) {
    $dbName = DB_NAME;
    $collectionName = $this->collectionName;
    $db = $mongoClient->$dbName;
    $this->collection = $db->$collectionName;
  }

  public function findById(string $id) {
    $document = $this->collection->findOne(['_id' => new ObjectId($id)]);
    return $document;
  }

  public function findBy(array $filter) {
    $documents = [];
    $query = $this->collection->find($filter);

    foreach ($query as $document) {
      $documents[] = $document;
    }

    return $documents;
  }

  public function create($fields) {
    $data = $this->collection->insertOne($fields);

    return $data->getInsertedId();
  }
}
