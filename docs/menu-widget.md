# Add menu widget

See commit here - [Commit changes](https://github.com/tonephp/tonephp/commit/fd6b5523f691cb75df51d423d018fd1fe8599474)

## 1. Work with database table

### -- Create table

```sql
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### -- Add primary key and set auto increment

```sql
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
```

### -- Insert data

```sql
INSERT INTO `category` (`id`, `parent_id`, `title`) VALUES
(1, 0, '1'),
(2, 0, '2'),
(3, 1, '1.1'),
(4, 2, '2.1');
```

## 2. Work with widget folder

### -- Create file `app/widgets/menu/Menu.php`

```php
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
```

### -- Create template file `app/widgets/menu/templates/menu/menu.php`

```php
<li>
  <a target="_blank" href="/category/<?=$category['title'];?>">
    <?=$tab . $category['title'];?>
  </a>
  <?php if (isset($category['childs'])) : ?>
    <ul>
      <?=$this->getMenuHtml($category['childs'], $tab . '--');?>
    </ul>
  <?php endif; ?>
</li>
```

## 3. Create model

### -- Create model file `app/models/Category.php`

```php
<?php

namespace app\models;

use core\base\Model;

class Category extends Model {
  
  public $table = 'category';
}
```

## 4. Add function

### -- Add function into file `app/functions.php`

```php
function getAttrs($options) {
  $attrs = '';
  
  if (!empty($options)) {
    foreach ($options as $k => $v) {
      $attrs .= " $k='$v'";
    }
  }

  return $attrs;
}
```

## 5. FINAL. See how to use menu widget

To find how to use menu widget follow this link - [README.md#menu-widget-usage](https://github.com/tonephp/tonephp/blob/main/README.md#menu-widget-usage)
