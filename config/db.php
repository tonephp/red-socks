<?php

$db_host = $_ENV['DB_HOST'];
$db_user = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASSWORD'];
$db_name = $_ENV['DB_NAME'];

return [
  'dsn' => "mysql:host=$db_host;dbname=$db_name;charset=utf8",
  'user' => $db_user,
  'pass' => $db_password
];