<?php

namespace core;

use core\ErrorHandler;

class Tone {

  public static $app;

  public function __construct() {
    session_start();
    self::$app = Registry::instance();
    $this->getParams();
    new ErrorHandler;
  }

  protected function getParams(){
    $params = require_once CONFIG . '/params.php';
    if(!empty($params)){
        foreach($params as $k => $v){
            self::$app->setProperty($k, $v);
        }
    }
  }

  public static function requireFunctions() {
    require __DIR__ . '/functions.php';
  }
}