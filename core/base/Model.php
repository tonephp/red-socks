<?php

namespace core\base;

use core\Db;
use Valitron\Validator as V;

class Model {
  
  protected $db;
  protected $table;
  protected $primaryKey = 'id';
  public $attributes = [];
  public $errors = [];
  public $rules = [];
  
  public function __construct() {
    $this->db = Db::instance();
  }

  public function load($data) {
    foreach ($this->attributes as $name => $value) {
      if (isset($data[$name])) {
        $this->attributes[$name] = $data[$name];
      }
    }
  }

  public function save($table = null) {
    $table = $table ?? $this->table;
    $propetries = implode(", ", array_keys($this->attributes));
    $questions = preg_replace( '#[^,]+#', '?', $propetries);

    $sql = "INSERT INTO `$table` (" . $propetries . ") VALUES (" . $questions . ")";
    $saved = $this->db->execute($sql, array_values($this->attributes));
    
    return $saved;
  }

  public function validate() {
    $v = new V($this->attributes);
    $v->rules($this->rules);

    if ($v->validate()) {
      return true;
    }

    $this->errors = $v->errors();

    return false;
  }

  public function getErrors() {
    $errors = '<ul>';

    foreach ($this->errors as $error) {
      foreach ($error as $item) {
        $errors .= "<li>$item</li>";
      }
    }
    $errors .= '</ul>';

    $_SESSION['errors'] = $errors;
  }

  public function query($sql) {
    return $this->db->execute($sql);
  }

  public function findAll() {
    $sql = "SELECT * FROM {$this->table}";

    return $this->db->query($sql);
  }

  public function findOne($id, $field = '') {
    $field = $field ?: $this->primaryKey;
    $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";

    return $this->db->query($sql, [$id]);
  }

  public function findBySql($sql, $params = []) {
    return $this->db->query($sql, $params);
  }

  public function findLike($str, $field, $table = '') {
    $table = $table ?: $this->table;
    $sql = "SELECT * FROM $table WHERE $field LIKE ?";

    return $this->db->query($sql, ['%' . $str . '%']);
  }

  public function convertToAssoc($items, $itemKey = 'id', $saveKey = false) {
    $assocItems = [];
    $itemKey = $itemKey ?? 'id';
    
    foreach ($items as $item) {
      
      $keys = array_keys($item);
      $id = $item[$itemKey];

      foreach ($keys as $key => $value) {
        if ($value != $itemKey) {
          $assocItems[$id][$value] = $item[$value];

          if ($saveKey) {
            $assocItems[$id][$itemKey] = $id;
          }
        }
      }
    }

    return $assocItems;
  }

  public function getSlotsFromArr($arr) {
    $arrCount = count($arr);
    $slots = [];
    for ($i = 0; $i < $arrCount; $i++) {
      $slots[] = '?';
    }
    $slots = implode(',', $slots);

    return $slots;
  }
}