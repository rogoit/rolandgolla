<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/../vendor/autoload.php';

Symfony\Component\Debug\Debug::enable();

$app = new App\Application('dev');

$app->get('/php-kurs-inhouse-schulung/', function () use ($app) {
    return $app['twig']->render('php-kurs-inhouse-schulung.html.twig');
});

$app->run();
