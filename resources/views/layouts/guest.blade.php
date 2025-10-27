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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-1 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            
            <div class="w-full sm:max-w-md mt-1 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex justify-center space-x-3">
                    <a href="/" class="flex items-center space-x-3">
                        <x-application-logo class="block w-20 h-20 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                    <span class="text-2xl font-semibold py-6 text-gray-900 dark:text-white">
                        Dealify
                    </span>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
