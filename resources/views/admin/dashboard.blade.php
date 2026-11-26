<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Панель администратора — NekoMang</title>

    <link rel="stylesheet"
          href="{{ asset('css/auth.css') }}">
</head>
<body>

<header class="header">
    <a href="{{ route('home') }}" class="logo">
        NekoMang — Admin
    </a>
</header>

<main class="auth-container">

    <section class="auth-card admin-card">

        <h1>Панель администратора</h1>

        <div class="success-message">
            Доступ администратора разрешён.
        </div>

        <p>
            Добро пожаловать,
            <strong>{{ auth()->user()->name }}</strong>!
        </p>

        <h2>Статистика системы</h2>

        <div class="stats-grid">

            <div class="stat-card">
                <strong>{{ $usersCount }}</strong>
                <span>Пользователи</span>
            </div>

            <div class="stat-card">
                <strong>{{ $mangaCount }}</strong>
                <span>Произведения</span>
            </div>

            <div class="stat-card">
                <strong>{{ $genresCount }}</strong>
                <span>Жанры</span>
            </div>

            <div class="stat-card">
                <strong>{{ $chaptersCount }}</strong>
                <span>Главы</span>
            </div>

            <div class="stat-card">
                <strong>{{ $reviewsCount }}</strong>
                <span>Отзывы</span>
            </div>

        </div>

        <p class="subtitle">
            Управление мангой, главами, жанрами
            и пользователями будет реализовано
            на шестом дне.
        </p>

        <p class="auth-link">
            <a href="{{ route('profile.index') }}">
                Личный кабинет
            </a>
        </p>

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
