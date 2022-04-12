<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\UserController;

class ControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        $userController = new UserController();
        //test register
        $username = "test";
        $password = "test";
        $email = "test@test.com";
        $response = $userController->register($username, $password, $email);
    }
}
