<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:50',
                    'unique:users,name',
                ],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:72',
                    'confirmed',
                ],

                'terms' => [
                    'required',
                    'accepted',
                ],
            ],
            [
                'name.required' =>
                    'Введите имя пользователя.',

                'name.min' =>
                    'Имя должно содержать минимум 3 символа.',

                'name.max' =>
                    'Имя не должно превышать 50 символов.',

                'name.unique' =>
                    'Это имя пользователя уже занято.',

                'email.required' =>
                    'Введите электронную почту.',

                'email.email' =>
                    'Введите корректную электронную почту.',

                'email.unique' =>
                    'Пользователь с такой почтой уже существует.',

                'password.required' =>
                    'Введите пароль.',

                'password.min' =>
                    'Пароль должен содержать минимум 8 символов.',

                'password.max' =>
                    'Пароль не должен превышать 72 символа.',

                'password.confirmed' =>
                    'Пароли не совпадают.',

                'terms.required' =>
                    'Необходимо принять правила использования.',

                'terms.accepted' =>
                    'Необходимо принять правила использования.',
            ]
        );

        $role = Role::where('slug', 'reader')
            ->firstOrFail();

        $user = new User();

        $user->name = $validated['name'];

        $user->email = $validated['email'];

        $user->password = Hash::make(
            $validated['password']
        );

        $user->role_id = $role->id;

        $user->save();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Регистрация успешно завершена! '
                . 'Теперь войдите в свой аккаунт.'
            );
    }
}
