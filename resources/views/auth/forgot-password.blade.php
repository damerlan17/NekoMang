<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Восстановление пароля — NekoMang</title>

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

        <h1>Восстановление пароля</h1>

        <p class="subtitle">
            Введите электронную почту,
            указанную при регистрации.
        </p>

        @if (session('success'))

            <div class="success-message" role="status">
                {{ session('success') }}
            </div>

        @endif

        <form action="{{ route('password.email') }}"
              method="POST">

            @csrf

            <div class="form-group">

                <label for="email">
                    Электронная почта
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="example@mail.ru"
                       autocomplete="email"
                       maxlength="255"
                       required>

                @error('email')
                <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <button type="submit"
                    class="submit-button">

                Восстановить пароль

            </button>

        </form>

        <p class="auth-link">

            <a href="{{ route('login') }}">
                Вернуться ко входу
            </a>

        </p>

        <a href="{{ route('home') }}"
           class="back-link">

            Вернуться на главную

        </a>

    </section>

</main>

<footer class="footer">
    &copy; {{ date('Y') }} NekoMang
</footer>

</body>
</html>
