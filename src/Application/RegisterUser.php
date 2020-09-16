<?php

namespace Acme\Application;

use Acme\Domain\User;
use Acme\Domain\UserRepository;

class RegisterUser
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($name, $email)
    {
        $user = new User($name, $email);
        $this->userRepository->save($user);
        return $user;
    }
}
