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

throw new \Exception("Esto es un error");
