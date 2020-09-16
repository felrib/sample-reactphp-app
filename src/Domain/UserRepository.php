<?php

namespace Acme\Domain;

interface UserRepository
{
    public function save(User $user);

    public function all();
}
