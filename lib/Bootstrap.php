<?php declare(strict_types = 1);

namespace NoFramework;
require __DIR__ .'/../vendor/autoload.php';
define('ENVIRONMENT', 'development');
error_reporting(E_ALL);

/**
 * Register the error handler
 */
$whoops = new \Whoops\Run;
if (ENVIRONMENT != 'production') {
    $whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler( function($e) {
        echo 'Todo: Enviarle email al desarrollador';
    });
}

$whoops->register();

/**
 * Register HTTP request and response handlers
 */
$request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new \Http\HttpResponse;

/**
 * Definir las rutas
 */
$routesDefinitionCallback = function(\FastRoute\RouteCollector $r) {
    $routes = include_once('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};
$dispatcher = \FastRoute\simpleDispatcher($routesDefinitionCallback);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response->setContent('404 - no encontrado');
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Metodo no disponible');
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        $class = new $className;
        $class->$method($vars);
        break;
}


