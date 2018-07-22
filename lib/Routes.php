<?php declare(strict_types = 1);

return array(
    array('GET', '/hola-mundo', function() {
        echo 'Hola Mundo';
    }),
    array( 'GET', '/saludo', function() {
        echo 'saludando al mundo';
    } )
);
