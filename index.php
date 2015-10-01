<?php

require_once __DIR__ . '/vendor/autoload.php';

use Redneck1\SilexCookieProvider\SilexCookieProvider;

$app = new Silex\Application();

$app->register(new SilexCookieProvider());

$app->get('/', function() use ($app) {
    return new \Symfony\Component\HttpFoundation\Response("Your cookie is: " . $app['cookie']->get('some'));
});

$app->get('/set', function() use ($app) {
    $app['cookie']->set('some', 'test');

    return new \Symfony\Component\HttpFoundation\RedirectResponse('/');
});

$app->get('/remove', function() use ($app) {
    $app['cookie']->remove('some');

    return new \Symfony\Component\HttpFoundation\RedirectResponse('/');
});

$app->run();