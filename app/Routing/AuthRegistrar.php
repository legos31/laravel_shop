<?php


namespace App\Routing;


use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function() {
            Route::controller(SignInController::class)->group(function() {
                Route::get('/login', 'page')->name('login');
                Route::post('/login', 'handle')
                    ->middleware('throttle:auth')
                    ->name('login.handle');
                Route::delete('/logout', 'logout')->name('logout');
            });

            Route::controller(SignUpController::class)->group(function() {
                Route::get('/sign-up', 'page')->name('register');
                Route::post('/sign-up', 'handle')
                    ->middleware('throttle:auth')
                    ->name('register.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function() {
                Route::get('/forgot-password', 'page')->middleware('guest')->name('forgot');

                //    Route::post('/forgot-password', 'handle')
                //        ->middleware('quest')
                //        ->name('password.email');

                Route::post('/forgot-password', function (Request $request) {
                    $request->validate(['email' => 'required|email']);

                    $status = Password::sendResetLink(
                        $request->only('email')
                    );
                    if ($status === Password::RESET_LINK_SENT){
                        flash()->alert($status);
                        return back();
                    }
                    return back()->withErrors(['email' => __($status)]);
                })->middleware('guest')->name('forgot.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function() {
                Route::get('/reset-password/{token}', 'page')
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', 'handle')
                    ->middleware('guest')
                    ->name('password.reset.handle');
            });

            Route::controller(SocialAuthController::class)->group(function() {
                Route::get('/auth/socialite/{driver}', 'redirect')->name('socialite');

                Route::get('/auth/socialite/github/callback/', 'callback')->name('socialite.callback');
            });
        });
    }
}
