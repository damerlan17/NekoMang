<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Вход — NekoMang</title>

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

        <h1>Вход</h1>

        <p class="subtitle">
            Войдите в свой аккаунт NekoMang
        </p>

        @if (session('success'))
            <div class="success-message" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-summary" role="alert">
                Не удалось выполнить вход.
            </div>
        @endif

        <form action="{{ route('login.store') }}"
              method="POST"
              id="login-form">

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
                       autocomplete="username"
                       maxlength="255"
                       required>

                @error('email')
                <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="password">
                    Пароль
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Введите пароль"
                       autocomplete="current-password"
                       required>

                @error('password')
                <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <label class="checkbox-group">

                <input type="checkbox"
                       name="remember"
                       value="1"
                    @checked(old('remember'))>

                <span>Запомнить меня</span>

            </label>

            <button type="submit"
                    id="login-button"
                    class="submit-button">

                Войти

            </button>

        </form>

        @if (Route::has('password.request'))
            <p class="auth-link">
                <a href="{{ route('password.request') }}">
                    Забыли пароль?
                </a>
            </p>
        @endif

        <p class="auth-link">
            Нет аккаунта?

            <a href="{{ route('register') }}">
                Зарегистрироваться
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

<script>
    const form = document.getElementById('login-form');

    const button = document.getElementById('login-button');

    function validateForm() {
        button.disabled = !form.checkValidity();
    }

    form.addEventListener('input', validateForm);

    validateForm();
</script>

</body>
</html>
