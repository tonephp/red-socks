# TonePHP Framework 👋

# Create site using Starter Kit 🚀

Follow this link to start using TonePHP - [tonephp/starter-kit](https://github.com/tonephp/starter-kit)

# DOCS

## Currency widget

### Currency widget usage

### -- Insert currency select in file `app/components/header/header.php`:

Add this line into the div with class "header\_\_cell"

```php
<?php new \app\widgets\currency\Currency(); ?>
```

### -- Edit file `app/components/hero/hero.php`:

Add this code after the div with class "hero\_\_logo"

```php
<div>
  <?=\app\widgets\currency\Currency::calculatePriceWithCurrency(100);?>
</div>
```

### How to create Currency widget

- Create Currency widget - [currency-widget.md](docs/currency-widget.md)

## Menu widget

### Menu widget usage

### -- Insert this code in the file `app/components/header/header.php`:

Add this code after the first div with class "header\_\_cell"

```php
<div class="header__cell">
    <?php new \app\widgets\menu\Menu([
        'tpl' => APP . '/widgets/menu/templates/menu/menu.php',
        'container' => 'ul',
    ]);?>
</div>
```

### How to create Menu widget

- Create Menu widget - [menu-widget.md](docs/menu-widget.md)
