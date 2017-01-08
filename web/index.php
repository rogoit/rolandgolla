<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/../vendor/autoload.php';

Symfony\Component\Debug\Debug::enable();

$app = new App\Application('dev');

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->get('/php-kurs-inhouse-schulung', function () use ($app) {
    return $app['twig']->render('php-kurs-inhouse-schulung.html.twig');
});


$app->post('/emailform/', function (Request $request) use ($app) {
    $email = $request->request->get('email');

    $email = (filter_var($email, FILTER_VALIDATE_EMAIL));

    if($email) {
        mail('rolandgolla@gmail.com', 'Kontakt LP', $email);
    }

    $post = array(
        'msg' => 'ok'
    );

    return $app->json($post, 201);
});

$app->run();
