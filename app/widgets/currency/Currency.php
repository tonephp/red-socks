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