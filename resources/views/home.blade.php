<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>

    <link rel="stylesheet"
          href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="header">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            Neko<span>Mang</span>
        </a>
    </div>
</header>

<main class="main">
    <div class="container">
        <section class="welcome">
            <span class="tag">Курсовой проект</span>

            <h1>Добро пожаловать в NekoMang!</h1>

            <p>{{ $description }}</p>

            <p class="subtitle">
                Открывай новые истории и читай любимую мангу.
            </p>

            <div class="status">
                Сайт успешно запущен
            </div>

            <div class="technology">
                <span>Laravel 12</span>
                <span>PHP 8.2</span>
                <span>MySQL 8.0</span>
                <span>Blade</span>
            </div>
        </section>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} NekoMang.
            Курсовой проект.</p>
    </div>
</footer>

</body>
</html>
