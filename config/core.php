<?php

\App\Utility\Steve::initialize();
\App\Utility\Steve::note('Configurations');
require 'debug.php';
require 'config.php';

\App\Utility\Steve::note('DI Container');

$di = new DCP\Di\Container();

$di
    ->register(App\Framework\Configuration::class, 'config')
    ->toClass()
    ->addArgument('data', $config)
    ->asShared()
;

require 'di.php';

\App\Utility\Steve::close('DI Container');
