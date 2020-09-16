<?php

namespace Acme\Application;

use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    public function v1()
    {
        return Uuid::uuid1();
    }
}
