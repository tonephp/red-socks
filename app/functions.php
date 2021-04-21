<?php

function getAttrs($options) {
  $attrs = '';
  
  if (!empty($options)) {
    foreach ($options as $k => $v) {
      $attrs .= " $k='$v'";
    }
  }

  return $attrs;
}