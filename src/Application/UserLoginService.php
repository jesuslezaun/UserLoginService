<?php

namespace UserLoginService\Application;

use UserLoginService\Domain\User;

class UserLoginService
{

    const LOGIN_CORRECTO = "Login correcto";
    const LOGIN_INCORRECTO = "Login incorrecto";
    const OK = "Ok";
    const USUARIO_NO_LOGEADO = "Usuario no logeado";
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
            return self::LOGIN_CORRECTO;
        }

        return self::LOGIN_INCORRECTO;
    }

    public function logout(User $user): string
    {
        if(!in_array($user, $this->loggedUsers))
        {
            return self::USUARIO_NO_LOGEADO;
        }

        $this->sessionManager->logout($user->getUserName());
        return self::OK;
    }
}