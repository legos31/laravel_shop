<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;


class SignInController extends Controller
{
    public function page(): Factory|View|Application|string
    {
        return view('auth.login');
    }

    public function handle (SignInFormRequest $request) :RedirectResponse
    {


        if (!Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }


        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout (Request $request) :RedirectResponse
    {
        SessionRegenerator::run(fn() => auth()->logout());


        return redirect(route('home'));
    }
}
