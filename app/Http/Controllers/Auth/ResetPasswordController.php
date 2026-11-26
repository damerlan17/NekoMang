<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function create(
        Request $request,
        string $token
    ): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function store(
        Request $request
    ): RedirectResponse
    {
        $request->validate(
            [
                'token' => [
                    'required',
                    'string',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:72',
                    'confirmed',
                ],
            ],
            [
                'email.required' =>
                    'Введите электронную почту.',

                'email.email' =>
                    'Введите корректную электронную почту.',

                'password.required' =>
                    'Введите новый пароль.',

                'password.min' =>
                    'Пароль должен содержать минимум 8 символов.',

                'password.max' =>
                    'Пароль не должен превышать 72 символа.',

                'password.confirmed' =>
                    'Пароли не совпадают.',
            ]
        );

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function (User $user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                ]);

                $user->setRememberToken(
                    Str::random(60)
                );

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Пароль успешно изменён! '
                    . 'Войдите с новым паролем.'
                );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' =>
                    'Ссылка восстановления недействительна '
                    . 'или срок её действия истёк.',
            ]);
    }
}
