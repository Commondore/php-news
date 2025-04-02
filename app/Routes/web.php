<?php

use Phroute\Phroute\RouteCollector;
use App\Controllers\UserController;
use App\Controllers\HomeController;

$router = new RouteCollector();

$router->get('/', [HomeController::class, 'index']);

$router->get('/users', [UserController::class, 'index']);

$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'register']);


return $router;
