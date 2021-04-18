# Website made with TonePHP 👋

# First Usage 🚀

Clone repository
```
git clone https://github.com/tonephp/tonephp.git
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

Install npm modules with `npm install` or `yarn install`

Run webpack with `npm start` or `yarn start`

Import database from file `tonephp_db.sql` using phpmyadmin.
- Open link `http://localhost:40002`
- Login with this credentials
```
login - user
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
