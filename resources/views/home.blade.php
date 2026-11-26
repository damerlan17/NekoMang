<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>NekoMang — Главная страница</title>

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

        @if (session('success'))

            <div class="success-message" role="status">
                {{ session('success') }}
            </div>

        @endif

        <h1>Добро пожаловать в NekoMang!</h1>

        <p class="subtitle">
            Информационная система для чтения манги
        </p>

        @guest

            <p>
                Вы находитесь на сайте как гость.
            </p>

            <p class="auth-link">
                <a href="{{ route('login') }}">
                    Войти
                </a>
            </p>

            <p class="auth-link">
                <a href="{{ route('register') }}">
                    Зарегистрироваться
                </a>
            </p>

        @endguest

        @auth

            <div class="success-message">
                Вы авторизованы в системе.
            </div>

            <p>
                <strong>Имя пользователя:</strong>
                {{ auth()->user()->name }}
            </p>

            <p>
                <strong>Электронная почта:</strong>
                {{ auth()->user()->email }}
            </p>

            <p>
                <strong>Роль:</strong>
                {{ auth()->user()->role->name }}
            </p>

            <p class="auth-link">

                <a href="{{ route('profile.index') }}">
                    Личный кабинет
                </a>

            </p>

            @if (auth()->user()->isAdmin())

                <div class="success-message">
                    Вы вошли как администратор.
                </div>

                <p class="auth-link">

                    <a href="{{ route('admin.dashboard') }}">
                        Панель администратора
                    </a>

                </p>

            @else

                <p>
                    Вы вошли как читатель.
                </p>

            @endif

            <form action="{{ route('logout') }}"
                  method="POST">

                @csrf

                <button type="submit"
                        class="submit-button">

                    Выйти из аккаунта

                </button>

            </form>

        @endauth

    </section>

</main>

<footer class="footer">
    &copy; {{ date('Y') }} NekoMang
</footer>

</body>
</html>
