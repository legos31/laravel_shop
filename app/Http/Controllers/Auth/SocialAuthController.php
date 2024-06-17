<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;

class SocialAuthController extends Controller
{
    public function redirect(string $driver): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Throwable $exception) {
            throw new \DomainException('Not supported!');
        }
    }

    public function callback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();


        $user = User::query()->updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->nickname ?? $githubUser->email,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(10))
        ]);


        SessionRegenerator::run(fn() => auth()->login($user));

        return redirect()->intended(route('home'));
    }
}
