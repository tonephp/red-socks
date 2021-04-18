# Website made with TonePHP 👋

## Login credentials

```
login - admin
password - admin123
```

# DOCS

## Currency widget

### Currency widget usage

### -- Insert currency select in file `app/components/header/header.php`:

Add this line into the div with class "header__cell"
```php
<?php new \app\widgets\currency\Currency(); ?>
```
### -- Edit file `app/components/hero/hero.php`:

Add this code after the div with class "hero__logo"
```php
<div>
  <?=\app\widgets\currency\Currency::calculatePriceWithCurrency(100);?>
</div>
```


### How to create Currency widget

* Create Currency widget - [currency-widget.md](core/docs/currency-widget.md)
