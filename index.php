<?php

use App\Utils\View;

require __DIR__ . '/vendor/autoload.php';
define('URL', 'http://localhost/app');

View::init([
  'URL' => URL
]);

use App\Http\Router;

$router = new Router(URL);
include __DIR__ . '/routes/web.php';
