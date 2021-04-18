<?php

namespace app\controllers;

use core\base\Controller;
use core\Tone;
use app\widgets\currency\Currency;

class AppController extends Controller {
  
  public function __construct($route) {
    parent::__construct($route);

    $currencies = Currency::getCurrencies();
    $currentCurrency = Currency::getCurrentCurrency($currencies);

    Tone::$app->setProperty('currencies', $currencies);
    Tone::$app->setProperty('currency', $currentCurrency);
  }
}