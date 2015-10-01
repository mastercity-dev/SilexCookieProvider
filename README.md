# SilexCookieProvider
A couple of classes to provide access to cookies with no bullets in feet.

```
<?php

require __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use Redneck1\SilexCookieProvider\SilexCookieProvider;
use Symfony\Component\HttpFoundation\Response;

$app->register(new SilexCookieProvider([
  'salt' => 'abcde'
]));

$app->get('/get/{key}', function() use ($app) {
  return new Response(
    $app['cookie']->get($app['request']->get('key'));
  );
});
```
