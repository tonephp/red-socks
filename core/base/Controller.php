<?php

namespace core\base;

abstract class Controller {

  public $route = [];
  public $view;
  public $viewObj;
  public $layout;
  public $getMeta = null;
  public $vars = [];
  public $scripts = '';

  public function __construct($route) {
      $this->route = $route;
      $this->view = $route['action'];
  }

  public function getView() {
    $viewObj = $this->viewObj = new View($this->route, $this->layout, $this->view);
    $viewObj->scripts = $this->scripts;
    $viewObj->render($this->vars);
  }

  public function loadView($path, $vars = []) {
    return $this->viewObj->loadView($path, $vars);
  }

  public function addScript($script) {
    $this->scripts .= $script;
  }

  public function set($vars) {
    $this->vars = array_merge($this->vars, $vars);
  }

  public function setMeta($title = '', $desc = '', $keywords = '') {
    View::setMeta(
      $title,
      $desc,
      $keywords
    );
  }
}
