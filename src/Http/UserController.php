<?php

namespace Acme\Http;

use Acme\Application\RegisterUser;
use Acme\Application\UserService;
use Psr\Http\Message\RequestInterface;

class UserController
{
    private $registerUser;

    private $userService;

    public function __construct(RegisterUser $registerUser, UserService $userService)
    {
        $this->registerUser = $registerUser;
        $this->userService = $userService;
    }

    public function list()
    {
        return $this->userService->geList();
    }

    public function register(RequestInterface $request)
    {
        $this->registerUser->register('The user name', 'test@test.com');
    }
}
