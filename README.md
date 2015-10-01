# SilexCookieProvider
A couple of classes to provide access to cookies with no bullets in feet.

## Example

```
<?php

require __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use Redneck1\SilexCookieProvider\SilexCookieProvider;
use Symfony\Component\HttpFoundation\Response;

$app->register(new SilexCookieProvider());

$app->get('/get/{key}', function() use ($app) {
  return new Response(
    $app['cookie']->get($app['request']->get('key'));
  );
});
```

## Available methods

```
$app['cookie']->get($key);
$app['cookie']->getAll();
$app['cookie']->set($key, $value, $expires = 86400, $path = '/', $domain = false);
$app['cookie']->has($key);
$app['cookie']->remove($key);
```

## Future plans
Encrypted cookies.

```
$app['cookie']->getEncrypted($key);
$app['cookie']->setEncrypted($key, $value, $expires = 86400, $path = '/', $domain = false);
$app['cookie']->hasEncrypted($key);
$app['cookie']->removeEncrypted($key);
```
