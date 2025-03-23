<?php

use App\Controllers\UserController;
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->get('/', [UserController::class, 'index']);

return $router;
