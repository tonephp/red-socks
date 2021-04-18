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