<?php


namespace Tests\Feature\App\Http\Controllers\Auth;


use App\Listeners\SendEmailNewUserListener;
use Domain\Auth\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthControllerTest extends \Tests\TestCase
{

    /** @test */
    public function it_login_page_success()
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function it_sign_up_page_success()
    {
        $this->get(route('register'))
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
            'email' => 'legos0311@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);


        $response = $this->post(route('register.handle'), $request);
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

    /** @test */
    public function it_sign_in_success()
    {
        $request = [

            'email' => 'legos0311@gmail.com',
            'password' => '123456789',

        ];
        $response = $this->post(route('login.handle'), $request);
        $user = User::query()->where('email', $request['email'])->first();

        $this->assertAuthenticatedAs($user);


        $response->assertValid()->assertRedirect(route('home'));

    }
    /** @test */
    public function it_logout_success()
    {
        $request = [

            'email' => 'legos0311@gmail.com',
            'password' => '123456789',

        ];
        $user = User::query()->where('email', $request['email'])->first();
        $response = $this->actingAs($user)->delete(route('logout'), $request);
        $this->assertGuest();
    }

}

