<?php

namespace Auth;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    //use RefreshDatabase;
    /** @test */
    public function it_success_user_create() {
        $action = app(RegisterNewUserContract::class);
        $action(newUserDTO::make(['name' => 'Test', 'email' => 'testing@code.ru', 'password' => '111111111']));
        $this->assertDatabaseHas('users', [
            'email' => 'testing@code.ru'
        ]);
    }
}
