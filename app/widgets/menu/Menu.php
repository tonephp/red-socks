<?php

namespace app\widgets\menu;

use core\base\Widget;
use app\models\Category;

class Menu extends Widget {
  protected $menuHtml;
  protected $tpl;
  protected $container = 'ul';
  protected $class = '';
  protected $attrs = [];

  public function __construct($options = []) {
    $this->tpl = __DIR__ . '/templates/menu/menu.php';
    $this->getOptions($options);
    $this->run();
  }

  public function run() {
    
    $m_category = new Category();
    $tree = $m_category->getTree();

    $this->menuHtml = $this->getMenuHtml($tree);

    $this->output();
  }

  protected function output() {
    $attrs = getAttrs($this->attrs);

    echo "<{$this->container} class='{$this->class}' $attrs>";
    echo $this->menuHtml;
    echo "</{$this->container}>";
  }

  protected function getMenuHtml($tree, $tab = '') {
    $str = '';

    foreach ($tree as $id => $item) {
      $str .= $this->categoryToTemplate($item, $tab, $id);
    }

    return $str;
  }

  protected function categoryToTemplate($category, $tab = '', $id) {
    ob_start();

    require $this->tpl;

    return ob_get_clean();
  }
}