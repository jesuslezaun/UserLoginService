<?php

namespace UserLoginService\Application;

use UserLoginService\Domain\User;

class UserLoginService
{
    private array $loggedUsers = [];

    public function manualLogin(User $user): void
    {
        $this->loggedUsers[] = $user;
    }

    public function getLoggedUsers(): array
    {
        return $this->loggedUsers;
    }

    public function countExternalSessions(): int
    {
        return SessionManager::class->getSessions();
    }

}