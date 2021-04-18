# Add currency widget

## 1. Work with database table

### -- Create table

```sql
CREATE TABLE `currency` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(10) NOT NULL,
  `symbol_right` varchar(10) NOT NULL,
  `value` float(15,2) NOT NULL,
  `base` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### -- Add primary key and set auto increment

```sql
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `currency`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
```

### -- Insert data

```sql
INSERT INTO `currency` (`id`, `title`, `code`, `symbol_left`, `symbol_right`, `value`, `base`) VALUES
(1, 'гривна', 'UAH', '', 'грн.', 25.80, '0'),
(2, 'доллар', 'USD', '$', '', 1.00, '1'),
(3, 'Евро', 'EUR', '€', '', 0.88, '0');
```

## 2. Work with widgets directory

### -- If folder `widgets` in `app` directory does not exists, create folder `widgets`.

### -- Create folder `currency` in directory `app/widgets`.

### -- Create file `Currency.php` in directory `app/widgets/currency`.

```php
<?php

namespace app\widgets\currency;

use core\base\Widget;
use core\base\Model;
use core\Tone;
use app\models\Currency as CurrencyModel;

class Currency extends Widget {

  protected $template;
  protected $currencies;
  protected $currency;
  protected $m_currency;

  public function __construct($options = []) {
    $this->template = __DIR__ . '/templates/select/select.php';
    $this->getOptions($options);
    $this->m_currency = 
    $this->run();
  }

  public function run() {
    $this->currencies = Tone::$app->getProperty('currencies');
    $this->currency = Tone::$app->getProperty('currency');

    echo $this->getHtml();
  }

  public static function getCurrentCurrency($currencies) {
    $cur_key = $_COOKIE['currency'] ?? null;
    $has_in_array = array_key_exists($cur_key, $currencies);

    if (!($cur_key && $has_in_array)) {
      $cur_key = key($currencies);
    }
    
    $currentCurrency = $currencies[$cur_key];

    return $currentCurrency;
  }

  public static function getCurrencies() {
    $m_currency = new CurrencyModel();

    return $m_currency->getAll();
  }

  protected function getHtml() {
    ob_start();

    require $this->template;

    return ob_get_clean();
  }

  public static function calculatePriceWithCurrency($price) {
    $currency = Tone::$app->getProperty('currency');

    $number = $currency['value'] * $price;
    $symbol_left = $currency['symbol_left'];
    $symbol_left = $symbol_left ? $symbol_left . ' ' : null;
    $symbol_right = $currency['symbol_right'];
    $symbol_right = $symbol_right ? ' ' . $symbol_right : null;
    
    return $symbol_left . $currency['value'] * $price . $symbol_right;
  }
}
```

### -- Create folder `templates` in `app/widgets/currency`.

### -- Create folder `select` in `app/widgets/currency/templates`.

### -- Create file `select.php` in `templates` dir.

```php
<?php if ($this->currencies): ?>

  <select tabindex="4" id="js-currency-select">
    <option value="<?=$this->currency['code']?>" class="label"><?=$this->currency['code']?></option>
    <?php foreach ($this->currencies as $code => $item): ?>
      <?php if ($code != $this->currency['code']): ?>
        <option value="<?=$code?>">
          <?=$code?>
        </option>
      <?php endif; ?>
    <?php endforeach; ?>
  </select>

<?php endif; ?>
```

### -- Create file `select.js` in `templates` dir.

```js
const select = document.getElementById('js-currency-select');

if (select) {
  select.addEventListener('change', (event) => {
    window.location = `/currency/change?currency=${event.target.value}`;
  });
}
```

## 3. Import select's template script

### -- Add this line into file `app/src/app.js`:

```js
import '../widgets/currency/templates/select/select';
```

## 4. Create Currency model

### -- Create file `Currency.php` in folder `app/models`:

```php
<?php

namespace app\models;

use core\base\Model;

class Currency extends Model {
  
  public $table = 'currency';

  public function getAll() {
    $sql = "
      SELECT 
        code, title, symbol_left, symbol_right, value, base 
      FROM 
        $this->table
      ORDER BY base DESC
    ";
      
    $currencies = $this->db->query($sql);
    $currencies = $this->convertToAssoc($currencies, 'code', true);

    return $currencies;
  }

  public function getByCode($code) {
    $sql = "
      SELECT 
        *
      FROM 
        $this->table
      WHERE 
        code = ?
    ";

    $currency = $this->db->query($sql, [$code]);
    $currency = $currency[0];
    
    return $currency;
  }
}
```
