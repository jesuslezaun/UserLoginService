<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Doubles;

use UserLoginService\Application\SessionManager;

class StubSessionManager implements SessionManager
{
    public function getSessions(): int
    {
        return 2;
    }

    public function login(string $userName, string $password): bool
    {
    }

    public function logout(string $userName)
    {
    }

    public function secureLogin(string $userName, string $password): string
    {
    }
}