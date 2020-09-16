<?php

use DI\ContainerBuilder;

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$cbuilder = new ContainerBuilder();
$cbuilder->addDefinitions(__DIR__ . '/di.php');
$container = $cbuilder->build();

$app = new Acme\Application\App($loop, $container);

$app->listen('0.0.0.0:9090');

$loop->run();
