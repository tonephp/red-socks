<?php

namespace core;

use core\ErrorHandler;

class Tone {

  public static $app;

  public function __construct() {
    session_start();

    self::init();
    self::$app = Registry::instance();
    $this->getParams();
    new ErrorHandler;
    self::dispatchRouter();
  }

  protected static function init() {
    define('WWW', __DIR__ . '/../../../../public');
    define('ROOT', dirname(__DIR__ . '/../../../../..'));
    define('CORE', ROOT . '/core');
    define('CONFIG', ROOT . '/config');
    define('APP', ROOT . '/app');
    define('WIDGETS', APP . '/widgets');
    define('CACHE', ROOT . '/tmp/cache');
    define('LAYOUT', 'default');

    $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
    $dotenv->load();

    define("DEBUG", $_ENV['DEBUG']);

    require __DIR__ . '/functions.php';
    require APP . '/functions.php';
    require APP . '/routes.php';
  }

  protected static function dispatchRouter() {
    $query = $_SERVER['QUERY_STRING'];
    $query = rtrim($query, '/');
    Router::dispatch($query);
  }

  protected function getParams() {
    $params = require_once CONFIG . '/params.php';
    if(!empty($params)){
        foreach($params as $k => $v){
            self::$app->setProperty($k, $v);
        }
    }
  }
}
