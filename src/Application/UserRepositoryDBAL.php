<?php

namespace Acme\Application;

use Acme\Domain\User;
use Acme\Domain\UserRepository;
use DateTime;
use Doctrine\DBAL\Query\QueryBuilder;

class UserRepositoryDBAL implements UserRepository
{
    private $builder;

    /** @var UuidGenerator */
    private $uuidGenerator;

    public function __construct(QueryBuilder $builder, UuidGenerator $uuidGenerator)
    {
        $this->builder = $builder;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function all()
    {
        $this->builder->select()->from('users')->execute();
    }

    public function save(User $user)
    {
        $created_at = new DateTime();
        $this->builder->insert('users')
            ->values([
                'id' => '?',
                'name' => '?',
                'email' => '?',
                'created_at' => '?',
            ])
            ->setParameters([
                $this->uuidGenerator->v1()->toString(),
                $user->getName(),
                $user->getEmail(),
                $created_at->format('Y-m-d H:i:s'),
            ])->execute();
    }
}
