<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],

                'password' => [
                    'required',
                    'string',
                ],

                'remember' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'email.required' =>
                    'Введите электронную почту.',

                'email.email' =>
                    'Введите корректную электронную почту.',

                'password.required' =>
                    'Введите пароль.',
            ]
        );

        $key = 'login:' . Str::lower(
                $validated['email']
            ) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {

            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withErrors([
                    'email' =>
                        'Слишком много попыток входа. '
                        . 'Повторите через '
                        . $seconds . ' сек.',
                ])
                ->withInput(
                    $request->only('email', 'remember')
                );
        }

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            RateLimiter::hit($key, 60);

            return back()
                ->withErrors([
                    'email' =>
                        'Неверная электронная почта или пароль.',
                ])
                ->withInput(
                    $request->only('email', 'remember')
                );
        }

        RateLimiter::clear($key);

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with(
                'success',
                'Вы успешно вошли в аккаунт!'
            );
    }
}
