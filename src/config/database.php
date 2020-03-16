<?php
	require_once 'vendor/autoload.php';

	$dbConfig = json_decode(file_get_contents('config/dbConfig.json'));

	class Database {
		private $mongoUri;
		private $connection;
		private $db;
		private $collection;

		public function __construct() {
			global $dbConfig;

			$this->mongoUri = $dbConfig->mongoUri;
			$this->connection = new MongoDB\Client($this->mongoUri);
			
			$dbName = $dbConfig->dbName;
			$this->db = $this->connection->$dbName;

			$this->collection = $this->db->users;

			// $this->collection->createIndex(['email' => 1], ['unique' => 1]);
		}

		public function getCollection() {
			return $this->collection;
		}
		public function setCollection($collection) {
			$this->collection = $collection;
		}
	}
