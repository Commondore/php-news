<?php

use Phroute\Phroute\RouteCollector;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Middleware\ApiAuthMiddleware;

$router = new RouteCollector();

$router->filter('auth', function () {
  ApiAuthMiddleware::handle();
});

$router->get('/', [HomeController::class, 'index']);

$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'register']);

$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'login']);

$router->group(["before" => "auth"], function ($router) {
  $router->get('/users', [UserController::class, 'index']);

  $router->get('/api/me', [UserController::class, 'getMeJSON']);
});




return $router;
