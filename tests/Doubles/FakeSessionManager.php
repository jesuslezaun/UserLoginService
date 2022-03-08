<?php

namespace UserLoginService\Tests\Doubles;

use UserLoginService\Application\SessionManager;

class FakeSessionManager implements SessionManager
{
    public function getSessions(): int
    {
    }

    public function login(string $userName, string $password): bool
    {
        return $userName == "user_name" && $password == "password";
    }

    public function logout(string $userName)
    {
    }

    public function secureLogin(string $userName, string $password): string
    {
    }
}