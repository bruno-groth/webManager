<?php

use App\Common\Environment;
use App\Utils\View;

require __DIR__ . '/vendor/autoload.php';
define('URL', 'http://localhost/app');
Environment::load(__DIR__);

View::init([
  'URL' => getenv('URL')
]);


use App\Http\Router;

$router = new Router(URL);
include __DIR__ . '/routes/web.php';
