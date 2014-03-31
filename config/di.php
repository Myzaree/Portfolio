<?php

/** @var App\Framework\Configuration $config */
$config = $di->get('config');

$di
    ->register(App\Framework\Base\Router::class, 'router')
    ->toClass()
    ->addMethodCall('setControllerPrefix', [$config->get('app.controller')])
    ->asShared()
;

$di
    ->register(Symfony\Component\HttpFoundation\Request::class, 'request')
    ->toFactory(function () {
        return Symfony\Component\HttpFoundation\Request::createFromGlobals();
    })
    ->asShared()
;

$di
    ->register(League\Plates\Engine::class)
    ->toClass()
    ->addArgument('directory', $di->get('config')->get('path.template'))
    ->asShared()
;