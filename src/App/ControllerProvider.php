<?php

namespace App;

use Silex\Api\ControllerProviderInterface;
use Silex\Application as App;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

class ControllerProvider implements ControllerProviderInterface
{
    private $app;

    public function connect(App $app)
    {
        $app->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });

        $this->app = $app;

        $app->error([$this, 'error']);

        $controllers = $app['controllers_factory'];

        $controllers
            ->get('/', [$this, 'index'])
            ->bind('index');

        $controllers
            ->get('/php-schulung-training/', [$this, 'phpSchulungTraining'])
            ->bind('phpSchulungTraining');

        $controllers
            ->post('/emailform/', [$this, 'emailForm'])
            ->bind('emailForm');

        return $controllers;
    }

    public function index(App $app)
    {
        return $app['twig']->render('index.html.twig');
    }

    public function phpSchulungTraining(App $app)
    {
        return $app['twig']->render('php-schulung-training.html.twig');
    }

    public function emailForm(App $app, Request $request)
    {
        $email = $request->request->get('email');

        $email = (filter_var($email, FILTER_VALIDATE_EMAIL));

        if($email) {
            mail('rolandgolla@gmail.com', 'Kontakt LP', $email);
        }

        $post = array(
            'msg' => 'ok'
        );

        return $app->json($post, 201);
    }

    public function error(\Exception $e, Request $request, $code)
    {
        if ($this->app['debug']) {
            return;
        }

        switch ($code) {
            case 404:
                $message = 'The requested page could not be found.';
                break;
            default:
                $message = 'We are sorry, but something went terribly wrong.';
        }

        return new Response($message, $code);
    }
}
