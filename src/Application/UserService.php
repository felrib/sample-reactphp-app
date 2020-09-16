<?php

namespace Acme\Application;

use Acme\Domain\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function geList()
    {
        return $this->userRepository->all();
    }
}
