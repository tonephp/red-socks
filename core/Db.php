<?php

namespace core;

use \PDO;

class Db {

  use TSingletone;
  
  protected $pdo;

  protected function __construct() {
    $config = require ROOT . '/config/db.php';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $this->pdo = new PDO(
      $config['dsn'],
      $config['user'],
      $config['pass'],
      $options
    );
  }

  public function execute($sql, $params = []) {
    $statement = $this->pdo->prepare($sql);
    $statement->execute($params);

    return $this->pdo->lastInsertId();
  }

  public function query($sql, $params = []) {
    $statement = $this->pdo->prepare($sql);
    $res = $statement->execute($params);

    if ($res !== false) {
      return $statement->fetchAll();
    }

    return [];
  }
}