<?php

use Phroute\Phroute\RouteCollector;
use App\Controllers\UserController;
use App\Controllers\HomeController;

$router = new RouteCollector();

$router->get('/', [HomeController::class, 'index']);

$router->get('/users', [UserController::class, 'index']);


return $router;
