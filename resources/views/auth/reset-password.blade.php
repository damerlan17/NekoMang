<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Новый пароль — NekoMang</title>

    <link rel="stylesheet"
          href="{{ asset('css/auth.css') }}">
</head>
<body>

<header class="header">
    <a href="{{ route('home') }}" class="logo">
        NekoMang
    </a>
</header>

<main class="auth-container">

    <section class="auth-card">

        <h1>Новый пароль</h1>

        <p class="subtitle">
            Придумайте новый пароль для своего аккаунта.
        </p>

        @if ($errors->any())

            <div class="error-summary" role="alert">
                Проверьте введённые данные.
            </div>

        @endif

        <form action="{{ route('password.update') }}"
              method="POST">

            @csrf

            <input type="hidden"
                   name="token"
                   value="{{ $token }}">

            <div class="form-group">

                <label for="email">
                    Электронная почта
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $email) }}"
                       autocomplete="email"
                       required>

                @error('email')
                <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="password">
                    Новый пароль
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Минимум 8 символов"
                       autocomplete="new-password"
                       minlength="8"
                       maxlength="72"
                       required>

                @error('password')
                <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="password_confirmation">
                    Повторите пароль
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Повторите новый пароль"
                       autocomplete="new-password"
                       minlength="8"
                       maxlength="72"
                       required>

            </div>

            <button type="submit"
                    class="submit-button">

                Сохранить новый пароль

            </button>

        </form>

        <p class="auth-link">

            <a href="{{ route('login') }}">
                Вернуться ко входу
            </a>

        </p>

    </section>

</main>

<footer class="footer">
    &copy; {{ date('Y') }} NekoMang
</footer>

</body>
</html>
