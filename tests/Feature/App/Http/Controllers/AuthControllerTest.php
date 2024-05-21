<?php


namespace Tests\Feature\App\Http\Controllers;


use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthControllerTest extends \Tests\TestCase
{
    //use RefreshDatabase;
    /** @test */
    public function it_login_page_success()
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.index');
    }

    /** @test */
    public function it_sign_up_page_success()
    {
        $this->get(route('signUp'))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }


    /** @test */
    public function it_store_success () :void
    {
        \Event::fake();
        \Notification::fake();

        $request = [
            'name' => 'Test',
            'email' => 'legos0312@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(route('store'), $request);
        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        \Event::assertDispatched(Registered::class);
        \Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $user = User::query()->where('email', $request['email'])->first();

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);
        \Notification::assertSentTo($user, NewUserNotification::class);
        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

}

