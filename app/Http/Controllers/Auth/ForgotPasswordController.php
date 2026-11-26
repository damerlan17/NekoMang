<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],
            ],
            [
                'email.required' =>
                    'Введите электронную почту.',

                'email.email' =>
                    'Введите корректную электронную почту.',
            ]
        );

        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with(
            'success',
            'Если аккаунт с указанной почтой существует, '
            . 'на него будет отправлена ссылка '
            . 'для восстановления пароля.'
        );
    }
}
