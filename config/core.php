<?php

$config['path.base'] = realpath(__DIR__ . '/..');
$config['path.template'] = $config['path.base'] . '/views';
$config['path.index'] = $config['path.base'] . '/views/Index';
$config['path.index.name'] = 'Index';

$config = array_merge($config, [
    'base.host' => $_SERVER['SERVER_NAME'],

    'controller.prefix' => 'App\Controller',

    'dev' => false,
    'staging' => false,
    'public' => false
]);

switch ($config['base.host']) {
    case 'dev.cameroncondry.com':
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $config['dev'] = true;
        break;
    case 'staging.cameroncondry.com':
        $config['staging'] = true;
        break;
    default:
        $config['public'] = true;
        break;
}

$di = new DCP\Di\Container();

$di
    ->register(App\Framework\Configuration::class, 'config')
    ->toSelf()
    ->addArgument('data', $config)
    ->asShared()
;

/** @var App\Framework\Configuration $config */
$config = $di->get('config');

require 'di.php';
