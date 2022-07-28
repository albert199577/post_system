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
        <h5 class="mx-3">Laravel App</h5>
        <nav class="mx-3">
            <a href="{{ route('home.index') }}" class="mx-2">Home</a>
            <a href="{{ route('home.contact') }}" class="mx-2">Contact</a>
            <a href="{{ route('posts.index') }}" class="mx-2">Blog Posts</a>
            <a href="{{ route('posts.create') }}" class="mx-2">Add Blog Post</a>
        </nav>
    </div>
    <div class="container">
        @if (session('status'))
            <p style="color: 777">
                {{ session('status') }}
            </p>
        @endif
        @yield('content')
    </div>
</body>
</html>