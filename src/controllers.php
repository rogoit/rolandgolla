<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->get('/php-kurs-inhouse-schulung/', function () use ($app) {
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

//$app->error(function (\Exception $e, Request $request, $code) use ($app) {
//    if ($app['debug']) {
//        return;
//    }
//    // 404.html, or 40x.html, or 4xx.html, or error.html
//    $templates = array(
//        'errors/'.$code.'.html.twig',
//        'errors/'.substr($code, 0, 2).'x.html.twig',
//        'errors/'.substr($code, 0, 1).'xx.html.twig',
//        'errors/default.html.twig',
//    );
//    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
//});