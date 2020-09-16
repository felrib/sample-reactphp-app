<?php

use Acme\Application\UserRepositoryDBAL;
use Acme\Application\UuidGenerator;
use Acme\Domain\UserRepository;
use Acme\Http\Kernel;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

return [
    Dispatcher::class => function ($c) {
        return simpleDispatcher(function (RouteCollector $collector) {
            $collector->post('/users', 'Acme\\Http\\UserController@register');
            $collector->get('/users', 'Acme\\Http\\UserController@list');
        });
    },
    Kernel::class => function (ContainerInterface $c) {
        return new Kernel($c->get(Dispatcher::class), $c);
    },
    PDO::class => function () {
        $dsn = 'mysql:dbname=somedb;host=localhost';
        return new PDO($dsn, 'root', 'root');
    },
    QueryBuilder::class => function () {
        $conn = DriverManager::getConnection([
            'dbname' => 'somedb',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ]);
        return $conn->createQueryBuilder();
    },
    UserRepository::class => function ($container) {
        return new UserRepositoryDBAL(
            $container->get(QueryBuilder::class),
            new UuidGenerator()
        );
    }
];
