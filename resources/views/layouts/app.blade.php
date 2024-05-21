<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', env('APP_NAME'))</title>
    @vite(['resources/css/app.css','resources/js/app.js','resources/sass/main.sass'])

</head>
<body class="antialiased">
    @if($message = flash()->get())
        <div class="{{$message->class()}} p-5">
            {{$message->message()}}
        </div>
        {{session('message')}}
    @endif

@yield('content')
</body>
</html>
