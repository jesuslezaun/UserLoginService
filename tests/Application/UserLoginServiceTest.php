<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userIsLoggedIn()
    {
        $user = new User("user_Name");
        $expectedLoggedUsers = [$user];
        $userLoginService = new UserLoginService();

        $userLoginService->manualLogin($user);

        $this->assertEquals($expectedLoggedUsers, $userLoginService->getLoggedUsers());
    }

    /**
     * @test
     */
    public function thereIsNoLoggedUser()
    {
        $userLoginService = new UserLoginService();

        $loggedUsers = $userLoginService->getLoggedUsers();

        $this->assertEmpty($loggedUsers);
    }
}
