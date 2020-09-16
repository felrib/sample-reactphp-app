<?php

namespace Acme\Domain;

class User
{
    private $name;

    private $email;

    private $id;

    public function __construct(string $name, string $email, $id = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
