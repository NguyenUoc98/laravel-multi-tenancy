<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased">
<div
    class="relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 sm:items-center min-h-screen bg-[url('/images/bg_home_mobile.webp')] lg:bg-[url('/images/bg_home.webp')] bg-cover lg:bg-right bg-center">
    @if (Route::has('login'))
        <div class="fixed lg:top-0 lg:right-0 bottom-[5%] px-6 py-4 space-x-2">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="border border-gray-400 dark:text-gray-500 px-4 py-2 rounded-md text-gray-700 text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm text-white font-semibold px-4 py-2 rounded-md bg-[#00a888]">Đăng nhập</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-sm text-white font-semibold px-4 py-2 rounded-md bg-[#fa0]">Đăng ký</a>
                @endif
            @endauth
        </div>
    @endif
</div>
</body>
</html>
