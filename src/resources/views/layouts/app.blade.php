<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">

    @stack('css')
</head>

<body class="{{ request()->is('login') || request()->is('register') ? 'is-auth' : '' }}">
    <header class="header">
        <div class="header__inner {{ auth()->check() ? 'header__inner--auth' : '' }}">

            <div class="header__logo">FashionablyLate</div>

            @guest
            <div class="header__right">
                @if (request()->is('login'))
                <a href="{{ route('register') }}" class="logout__btn">register</a>
                @elseif (request()->is('register'))
                <a href="{{ route('login') }}" class="logout__btn">login</a>
                @endif
            </div>
            @endguest

            @auth
            <form method="POST" action="/logout">
                @csrf
                <button class="logout__btn">logout</button>
            </form>
            @endauth
        </div>
    </header>

    <main class="main">
        <div class="main__inner">
            @yield('content')
        </div>
    </main>
</body>

</html>