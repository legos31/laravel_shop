<?php
use Illuminate\Support\Facades\Vite;
?>
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
    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

        <!-- Page heading -->
            <div class="text-center">
                <a href="{{route('home')}}" class="inline-block" rel="home">
                    <img src="{{vite::image('logo.svg')}}" class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]" alt="CutCode">
                </a>
            </div>

            @yield ('content')

    </div>
</main>
</body>
</html>
