<?php

namespace core;

use Exception;

class ErrorHandler {

  public function __construct() {
    if (DEBUG) {
      error_reporting(-1);
    } else {
      error_reporting(0);
    }
    set_error_handler([$this, 'errorHandler']);
    ob_start();
    register_shutdown_function([$this, 'fatalErrorHandler']);
    set_exception_handler([$this, 'exceptionHandler']);
  }

  public function errorHandler($no, $str, $file, $line) {
    $this->logError($str, $file, $line);
    $this->displayError($no, $str, $file, $line);

    return true;
  }

  public function logError($str, $file, $line) {
    error_log(
      "[" . date('Y-m-d H:i:s') . "] Error text: {$str} | File: {$file} | Line: {$line}\n", 
      3,
      ROOT . "/tmp/errors.log"
    );
  }

  public function exceptionHandler($e) {
    $this->logError($e->getMessage(), $e->getFile(), $e->getLine());
    $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
  }

  public function fatalErrorHandler() {
    $error = error_get_last();

    if (
      !empty($error) 
      AND $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)
    ) {
      ob_end_clean();
      $this->logError($error['message'], $error['file'], $error['line']);
      $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
    } else {
      ob_end_flush();
    }
  }

  protected function displayError($no, $str, $file, $line, $response = 500) {
    
    if (is_numeric($response)) {
      http_response_code($response);
    } else {
      http_response_code(500);
    }
    
    if ($response == 404) {
      require WWW . '/error/404.php';
      die;
    }
    if (DEBUG) {
      require WWW . '/error/dev.php';
    } else {
      require WWW . '/error/prod.php';
    }
    die;
  }
}
