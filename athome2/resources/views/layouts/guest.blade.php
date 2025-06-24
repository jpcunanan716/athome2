<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-0 bg-gray-100">
    <div class="flex flex-col items-start w-full sm:max-w-md px-0 pl-6">
        <!-- Bigger minimal single-stroke fuchsia house icon logo -->
        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" aria-label="athome logo" xmlns="http://www.w3.org/2000/svg">
            <path d="M30 75 L60 37 L90 75 M38 75 V105 H82 V75" stroke="#C026D3" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <line x1="60" y1="105" x2="60" y2="86" stroke="#C026D3" stroke-width="8" stroke-linecap="round"/>
        </svg>
        <span class="text-5xl font-bold text-fuchsia-700 tracking-tight mt-4">athome</span>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
</div>
    </body>
</html>
