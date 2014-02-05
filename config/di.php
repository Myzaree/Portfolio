<?php

$di
    ->register(App\Framework\BaseRouter::class, 'router')
    ->toSelf()
    ->addMethodCall('setControllerPrefix', [$config->get('controller.prefix')])
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
    ->toSelf()
    ->addArgument('directory', $di->get('config')->get('path.template'))
    ->addMethodCalls([
        ['addFolder', [$config->get('path.index.name'), $config->get('path.index')]]
    ])
    ->asShared()
;
