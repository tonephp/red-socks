<?php

namespace core\base;

use Exception;

class View {

  public $route = [];
  public $view;
  public $layout;
  public $scripts = '';
  public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
  protected static $exceptionCode = DEBUG ? 500 : 404;

  public function __construct($route, $layout = '', $view = '') {
    $this->route = $route;

    if ($layout === false) {
      $this->layout = false;
    } else {
      $this->layout = $layout ?: LAYOUT;
    }
    
    $this->view = $view;
  }

  public function render($vars) {
    $viewDir = getViewDir($this->route);

    $file_view = $viewDir . "{$this->view}.php";
    if (is_array($vars)) extract($vars);
    
    ob_start();

    if (is_file($file_view)) {
      require $file_view;
    } else {
      $url = $this->route['url'];
      throw new Exception("Page $file_view not found. URL: $url", self::$exceptionCode);
    }

    $content = ob_get_clean();
    $scripts = $this->scripts;

    if (false !== $this->layout) {
      $file_layout = APP . "/layouts/{$this->layout}.php";

      if (is_file($file_layout)) {
        
        require $file_layout;
      } else {
        $url = $this->route['url'];
        throw new Exception("Layout $file_layout not found. URL: $url", self::$exceptionCode);
      }
    }
  }

  public static function getMeta() {
    echo '<title>' . self::$meta['title'] . '</title>
      <meta name="description" content="' . self::$meta['desc'] . '">
      <meta name="keywords" content="' . self::$meta['keywords'] . '">';
  }

  public static function setMeta($title = '', $desc = '', $keywords = '') {
    self::$meta['title'] = $title;
    self::$meta['desc'] = $desc;
    self::$meta['keywords'] = $keywords;
  }

  public function loadView($name, $vars = []) {
    $filePath = APP . "/{$name}.php";

    ob_start();
    extract($vars);
    require APP . "/{$name}.php";
    
    return ob_get_clean();
  }

  public function loadPart($name, $vars = []) {
    $viewDir = getViewDir($this->route);

    $filePath = $viewDir. "{$this->view}-parts/{$name}.php";

    ob_start();
    extract($vars);
    require $filePath;
    
    return ob_get_clean();
  }

  public function component($name, $vars = []) {
    $pieces = explode("/", $name);
    $filename = $name;
    $path = '';
    $count = count($pieces);

    if ($count > 1) {
      $filename = $pieces[$count - 1];
      array_pop($pieces);
      
      foreach ($pieces as $folder) {
        $path .= $folder . '/';
      }
    }

    $children = $vars['children'] ?? null;

    extract($vars);

    if ($children) {
      $children = $this->getChildren($children);
    }
    
    require APP . "/components/{$path}{$filename}/{$filename}.php";
  }

  public function isAuth() {
    return isset($_SESSION['user']);
  }

  public function getUser() {
    return $_SESSION['user'] ?? null;
  }

  public function getChildren($children) {
    ob_start();
    
    $file = $children;

    if (is_array($children)) {
      if (isset($children['data'])) {
        extract($children['data']);
      }
      
      $file = $children['file'];
    }
    
    require APP . "/{$file}.php";
    
    return ob_get_clean();
  }
}