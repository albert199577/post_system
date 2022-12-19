<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=`, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>Laravel App - @yield('title')</title>
</head>
<body>
    <div class="d-flex justify-content-between shadow-sm">
        <h5 class="mx-3"><a href=" {{ route('posts.index') }}">Laravel App</a></h5>
        <nav class="mx-3">
            <a href="{{ route('home.index') }}" class="mx-2">{{ __('Home') }}</a>
            <a href="{{ route('home.contact') }}" class="mx-2">{{ __('Contact') }}</a>
            <a href="{{ route('posts.index') }}" class="mx-2">{{ __('Blog Posts') }}</a>
            <a href="{{ route('posts.create') }}" class="mx-2">{{ __('Add') }}</a>

            @guest
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="mx-2">{{ __('Register') }}</a>
                @endif
                <a href="{{ route('login') }}"
                    class="mx-2">{{ __('Login') }}</a>
            @else
                <a href="{{ route('users.show', ['user' => Auth::user()->id]) }}" class="mx-2">{{ __('Profile') }}</a>
                <a href="{{ route('users.edit', ['user' => Auth::user()->id]) }}" class="mx-2">{{ __('Edit Profile') }}</a>
                <a href="{{ route('logout') }}" class="mx-2"
                    onclick="event.preventDefault(); document.querySelector('#logout-form').submit();">{{ __('Logout') }} ({{ Auth::user()->name }})</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>