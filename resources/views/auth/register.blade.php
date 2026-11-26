
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Регистрация — NekoMang</title>

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

        <h1>Регистрация</h1>

        <p class="subtitle">
            Создайте свой аккаунт в NekoMang
        </p>

        @if (session('success'))
            <div class="success-message" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-summary" role="alert">
                Проверьте правильность введённых данных.
            </div>
        @endif

        <form action="{{ route('register.store') }}"
              method="POST"
              id="register-form">

            @csrf

            <div class="form-group">

                <label for="name">
                    Имя пользователя
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Введите никнейм"
                       autocomplete="username"
                       minlength="3"
                       maxlength="50"
                       required>

                @error('name')
                <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

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

            <div class="form-group">

                <label for="password">
                    Пароль
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
                       placeholder="Повторите пароль"
                       autocomplete="new-password"
                       required>

            </div>

            <label class="checkbox-group">

                <input type="checkbox"
                       id="terms"
                       name="terms"
                       value="1"
                       @checked(old('terms'))
                       required>

                <span>
                    Я согласен с правилами использования
                    системы и обработкой персональных данных.
                </span>

            </label>

            @error('terms')
            <span class="error">
                    {{ $message }}
                </span>
            @enderror

            <button type="submit"
                    id="register-button"
                    class="submit-button">

                Зарегистрироваться

            </button>

        </form>

        <p class="auth-link">
            Уже есть аккаунт?

            @if (Route::has('login'))
                <a href="{{ route('login') }}">
                    Войти
                </a>
            @else
                <span>Вход будет доступен после настройки</span>
            @endif
        </p>

        @if (Route::has('password.request'))
            <p class="auth-link">
                <a href="{{ route('password.request') }}">
                    Восстановить доступ
                </a>
            </p>
        @endif

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
    const form = document.getElementById('register-form');

    const password = document.getElementById('password');

    const confirmation = document.getElementById(
        'password_confirmation'
    );

    const button = document.getElementById(
        'register-button'
    );

    function validateForm() {

        const passwordsMatch =
            password.value === confirmation.value;

        confirmation.setCustomValidity(
            passwordsMatch ? '' : 'Пароли не совпадают'
        );

        button.disabled = !form.checkValidity();
    }

    form.addEventListener('input', validateForm);

    form.addEventListener('change', validateForm);

    validateForm();
</script>

</body>
</html>
