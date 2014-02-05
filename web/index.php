<?php

require '../vendor/autoload.php';
require '../includes/debug.php';
require '../config/core.php';

use App\Framework\BaseRouter;
use DCP\Router\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;

/** @var BaseRouter $router */
$router = $di->get('router');

/** @var Request $request */
$request = $di->get('request');

dump($di);
//echo '<pre>';
//var_dump($di);
//echo '</pre>';

try {
    $router->dispatch($request->getPathInfo());
} catch (NotFoundException $e) {
    dump($e);
}
