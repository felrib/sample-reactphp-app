<?php

namespace Acme\Application;

use Acme\Domain\User;
use Acme\Domain\UserRepository;
use DateTime;
use PDO;

class UserRepositoryMySQL implements UserRepository
{
    /** @var PDO */
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function save(User $user)
    {
        $stmt = $this->conn->prepare('insert into users (id, name, email, created_at) values (uuid(), ?, ?, ?)');
        $created_at = new DateTime();
        var_dump($stmt->execute([$user->getName(), $user->getEmail(), $created_at->format('Y-m-d H:i:s')]));
        var_dump($stmt->errorInfo());
    }
}
