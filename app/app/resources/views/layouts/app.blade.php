<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=`, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel App - @yield('title')</title>
</head>
<body>
    <div>
        @if (session('status'))
            <p style="color: 777">
                {{ session('status') }}
            </p>
        @endif
        @yield('content')
    </div>
</body>
</html>