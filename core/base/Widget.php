<?php

namespace core\base;

class Widget {

  protected function getOptions($options) {
    foreach ($options as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
      }
    }
  }
}