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

$response->setContent('<h1>Error 404</h1>');
$response->setStatusCode(404);
foreach ($response->getHeaders() as $header) {
    header($header, false);
}

echo $response->getContent();
