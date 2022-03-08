<?php

namespace UserLoginService\Application;

use UserLoginService\Domain\User;

class UserLoginService
{

    private  SessionManager $sessionManager;
    private array $loggedUsers = [];

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

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
        return $this->sessionManager->getSessions();
    }

    public function login(string $userName, string $password): string
    {
        if($this->sessionManager->login($userName, $password))
        {
            $user = new User($userName);
            $this->loggedUsers[] = $user;
            return "Login correcto";
        }

        return "Login incorrecto";
    }
}