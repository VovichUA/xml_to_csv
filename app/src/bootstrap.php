<?php

use Src\Core\Router\Router;
use Src\Libs\Services\Session;

require_once __DIR__.'/../vendor/autoload.php';

Session::start();

$router = new Router();

require __DIR__.'/../src/app/routes.php';

$errors = Session::get('errors');