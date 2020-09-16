<?php

use Acme\Application\UserRepositoryDBAL;
use Acme\Application\UserRepositoryMySQL;
use Acme\Application\UuidGenerator;
use Acme\Domain\UserRepository;
use Acme\Http\Kernel;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

$container->set(Kernel::class, function ($container) use ($dispatcher) {
    return new Kernel($dispatcher, $container);
});
$container->set(PDO::class, function () {
    $dsn = 'mysql:dbname=somedb;host=localhost';
    return new PDO($dsn, 'root', 'root');
});
$container->set(UserRepository::class, function ($container) {
    return new UserRepositoryDBAL(
        $container->get(QueryBuilder::class),
        new UuidGenerator()
    );
});
$container->set(QueryBuilder::class, function () {
    $conn = DriverManager::getConnection([
        'dbname' => 'somedb',
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ]);
    return $conn->createQueryBuilder();
});
