<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Helpers\Flash;
use Phroute\Phroute\Dispatcher;

Flash::init();

$router = require __DIR__ . '/../app/Routes/web.php';

$dispatcher = new Dispatcher($router->getData());

$rootPath = dirname(__DIR__, 1); // путь до корня проекта
$dotenv = \Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


try {
  echo $dispatcher->dispatch($method, $uri);
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
  http_response_code(404);
  echo "Страница не найдена";
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
  http_response_code(405);
  echo "Метод не разрешён";
}
