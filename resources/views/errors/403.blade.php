<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>403 — Доступ запрещён</title>

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

        <h1 style="font-size: 64px; color: #FF6B6B;">
            403
        </h1>

        <h1>Доступ запрещён</h1>

        <div class="error-summary" role="alert">

            У вас недостаточно прав для доступа
            к этой странице.

        </div>

        <p class="subtitle">
            Данная страница доступна только
            администраторам системы.
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
