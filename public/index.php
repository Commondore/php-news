<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Phroute\Phroute\Dispatcher;

$router = require __DIR__ . '/../app/Routes/web.php';

$dispatcher = new Dispatcher($router->getData());

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = preg_replace('#^/news\.kg#', '', $uri);

try {
    echo $dispatcher->dispatch($method, $uri);
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    http_response_code(404);
    echo "Страница не найдена";
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
    http_response_code(405);
    echo "Метод не разрешён";
}
