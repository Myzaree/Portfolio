<?php

require '../vendor/autoload.php';
require '../config/core.php';

\App\Utility\Steve::note('Router');

/** @var App\Framework\Base\Router $router */
$router = $di->get('router');

/** @var Symfony\Component\HttpFoundation\Request $request */
$request = $di->get('request');

try {
    $router->dispatch($request->getPathInfo());
} catch (\DCP\Router\Exception\NotFoundException $e) {
    if ($di->get('config')->get('dev')) {
        dump($e);
    }
}
