<?php

namespace core;

class Cache {
  
  public function set($key, $data, $seconds = 3600) {
    $content['data'] = $data;
    $content['key'] = $key;
    $content['end_time'] = time() + $seconds;
    $fileName = CACHE . '/' . md5($key) . '.txt';

    if (file_put_contents($fileName, serialize($content))) {
      return true;
    }

    return false;
  }

  public function get($key) {
    $fileName = CACHE . '/' . md5($key) . '.txt';

    if (file_exists($fileName)) {
      $content = unserialize(file_get_contents($fileName));

      if (time() <= $content['end_time']) {
        return $content['data'];
      }

      unlink($fileName);
    }

    return false;
  }

  public function getSet($key, $callback, $seconds = 3600) {
    $data = $this->get($key);

    if (!$data) {
      $data = $callback();
      $this->set($key, $data, $seconds);
    }

    return $data;
  }

  public function delete($key) {
    $fileName = CACHE . '/' . md5($key) . '.txt';

    if (file_exists($fileName)) {
      unlink($fileName);
    }
  }
}