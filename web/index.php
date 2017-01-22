<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new App\Application('prod');

require __DIR__.'/../config/prod.php';

$app->run();
