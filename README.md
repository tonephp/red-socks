# Website made with TonePHP 👋

# First Usage 🚀

Clone repository

```
git clone https://github.com/tonephp/starter-kit.git
```

Go to project folder

```
cd tonephp
```

Run docker container

```
docker-compose up -d
```

Install composer

```
composer install
```

Copy .env.example into the .env

```
cp .env.example .env
```

Install npm modules with `npm install` or `yarn install`

Run webpack with `npm start` or `yarn start`

Import database from file `tonephp_db.sql` using phpmyadmin.

- Open link `http://localhost:40002`
- Login with this credentials

```
username - user
password - password
```

FINAL. Follow this link `http://localhost:40001`

## Website Login credentials

```
login - admin
password - admin123
```

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
