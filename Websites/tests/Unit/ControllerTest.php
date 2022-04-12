<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\UserController;

class ControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register()
    {

        $username = "test";
        $password = "test";
        $email = "test@test.com";
        $userController = new UserController();
        $this->assertEquals(1, $userController->register($username, $password, $email));
    }

}
