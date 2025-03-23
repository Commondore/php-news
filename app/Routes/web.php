<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->get('/', [HomeController::class, 'index']);

$router->get('/users', [UserController::class, 'index']);

$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'register']);

return $router;
