<?php

$config['path.base'] = realpath(__DIR__ . '/..');

$config = array_merge($config, [
    'path.host' => $_SERVER['SERVER_NAME'],

    'path.template' => $config['path.base'] . '/views',

    'app.controller' => 'App\Controller',

    'dev' => false,
    'staging' => false,
    'public' => false
]);

//$config['path.index.name'] = 'Home';

switch ($config['path.host']) {
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