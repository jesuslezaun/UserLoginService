<?php

namespace UserLoginService\Tests\Doubles;

class FakeSessionManager implements \UserLoginService\Application\SessionManager
{

    public function getSessions(): int
    {
    }

    public function login(string $userName, string $password): bool
    {
        return $userName == "user_name" && $password == "password";
    }
}