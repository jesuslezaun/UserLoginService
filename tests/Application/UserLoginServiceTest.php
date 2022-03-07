<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Doubles\DummySessionManager;
use UserLoginService\Tests\Doubles\StubSessionManager;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userIsLoggedIn()
    {
        $user = new User("user_Name");
        $sessionManager = new DummySessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $userLoginService->manualLogin($user);

        $this->assertEquals([$user], $userLoginService->getLoggedUsers());
    }

    /**
     * @test
     */
    public function thereIsNoLoggedUser()
    {
        $sessionManager = new DummySessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $loggedUsers = $userLoginService->getLoggedUsers();

        $this->assertEmpty($loggedUsers);
    }

    /**
     * @test
     */
    public function countsExternalSessions()
    {
        $sessionManager = new StubSessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $externalSessions = $userLoginService->countExternalSessions();

        $this->assertEquals(2, $externalSessions);
    }
}
