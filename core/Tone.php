<?php

namespace core;

use core\ErrorHandler;

class Tone {

  public static $app;

  public function __construct() {
    session_start();
    self::$app = Registry::instance();
    new ErrorHandler;
  }
}