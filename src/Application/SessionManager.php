<?php

namespace UserLoginService\Application;

interface SessionManager
{
    public function getSessions(): int;

    public function login(string $userName, string $password): bool;

    public function secureLogin(string $userName, string $password): string;

    public function logout(string $userName);
}