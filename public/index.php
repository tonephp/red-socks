<?php

use core\Tone;
use core\Router;

define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('CORE', ROOT . '/core');
define('APP', ROOT . '/app');
define('CACHE', ROOT . '/tmp/cache');
define('LAYOUT', 'default');

require '../vendor/autoload.php';

require CORE . '/functions.php';
require APP . '/functions.php';

$dotenv = Dotenv\Dotenv::createImmutable(WWW . '/..');
$dotenv->load();

define("DEBUG", $_ENV['DEBUG']);

new Tone;

require APP . '/routes.php';

$query = $_SERVER['QUERY_STRING'];
$query = rtrim($query, '/');
Router::dispatch($query);