<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Doubles\DummySessionManager;
use UserLoginService\Tests\Doubles\FakeSessionManager;
use UserLoginService\Tests\Doubles\SpySessionManager;
use UserLoginService\Tests\Doubles\StubSessionManager;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userIsLoggedInManually()
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

    /**
     * @test
     */
    public function userIsLoggedInExternalService()
    {
        $userName = "user_name";
        $password = "password";
        $sessionManager = new FakeSessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $loginResponse = $userLoginService->login($userName, $password);

        $this->assertEquals(UserLoginService::LOGIN_CORRECTO, $loginResponse);
    }

    /**
     * @test
     */
    public function userIsNotLoggedInExternalService()
    {
        $userName = "user_name";
        $password = "wrong_password";
        $sessionManager = new FakeSessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $loginResponse = $userLoginService->login($userName, $password);

        $this->assertEquals(UserLoginService::LOGIN_INCORRECTO, $loginResponse);
    }

    /**
     * @test
     */
    public function userNotLoggedOutUserNotBeingLoggedIn()
    {
        $user = new User("user_name");
        $sessionManager = new DummySessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $logoutResponse = $userLoginService->logout($user);

        $this->assertEquals(UserLoginService::USUARIO_NO_LOGEADO, $logoutResponse);
    }

    /**
     * @test
     */
    public function userLoggedOut()
    {
        $user = new User("user_name");
        $sessionManager = new SpySessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $userLoginService->manualLogin($user);
        $logoutResponse = $userLoginService->logout($user);

        $sessionManager->verifyLogoutCalls(1);
        $this->assertEquals(UserLoginService::OK, $logoutResponse);
    }
}
