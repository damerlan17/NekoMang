<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Личный кабинет — NekoMang</title>

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

        <h1>Личный кабинет</h1>

        <div class="success-message">
            Доступ разрешён.
        </div>

        <p>
            <strong>Имя пользователя:</strong>
            {{ $user->name }}
        </p>

        <p>
            <strong>Электронная почта:</strong>
            {{ $user->email }}
        </p>

        <p>
            <strong>Роль:</strong>
            {{ $user->role->name }}
        </p>

        <p>
            <strong>Дата регистрации:</strong>
            {{ $user->created_at->format('d.m.Y') }}
        </p>

        <p class="subtitle">
            Полноценный личный кабинет будет
            разработан на пятом дне.
        </p>

        @if ($user->isAdmin())

            <p class="auth-link">
                <a href="{{ route('admin.dashboard') }}">
                    Панель администратора
                </a>
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
