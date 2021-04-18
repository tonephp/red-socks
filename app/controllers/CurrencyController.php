<?php

namespace app\controllers;

use core\Tone;
use app\models\Currency;

class CurrencyController extends AppController {
    
    public function changeAction() {
        $code = $_GET['currency'] ?? null;

        if ($code) {
            $m_currency = new Currency();
            $currencyFromDb = $m_currency->getByCode($code);

            if (!empty($currencyFromDb)) {
                setcookie('currency', $code, time() + 3600*24*7, '/');
            }
        }

        redirect();
    }
}