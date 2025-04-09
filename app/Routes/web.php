<?php

use Phroute\Phroute\RouteCollector;
use App\Controllers\UserController;
use App\Controllers\HomeController;

$router = new RouteCollector();

$router->filter('auth', function (){
  if(!isset($_SESSION['user'])){
    http_response_code(404);
    echo "Страница не найдена";
    exit();
  }
});

$router->get('/', [HomeController::class, 'index']);

//$router->get('/users', [UserController::class, 'index']);

$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'register']);

$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'login']);

$router->group(['before' => 'auth'], function ($router) {
  $router->get('/users', [UserController::class, 'index']);
});


return $router;
