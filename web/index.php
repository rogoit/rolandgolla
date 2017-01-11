<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new App\Application('prod');

require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';

$app->run();
