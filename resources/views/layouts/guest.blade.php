<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

{{-- Scripts --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans text-gray-900 antialiased min-h-screen
             bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 overflow-x-hidden">

{{-- BACKGROUND DECOR --}}
<div class="fixed inset-0 -z-10 overflow-hidden">

    <div class="absolute top-0 left-0 w-56 h-56 sm:w-72 sm:h-72 bg-indigo-300 rounded-full blur-3xl opacity-30"></div>

    <div class="absolute bottom-0 right-0 w-56 h-56 sm:w-72 sm:h-72 bg-pink-300 rounded-full blur-3xl opacity-30"></div>

</div>



<div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 py-8">

    {{-- LOGO --}}
    <div class="mb-6 sm:mb-8 text-center">

        <a href="/" class="inline-block">

            <div class="bg-white/80 backdrop-blur-xl p-4 rounded-3xl shadow-xl border border-white/40">
                <x-application-logo class="w-14 h-14 sm:w-16 sm:h-16 fill-current text-indigo-600" />
            </div>

        </a>

        <h1 class="mt-4 text-lg sm:text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ config('app.name', 'Laravel') }}
        </h1>

        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            Smart Integrated Library System
        </p>

    </div>



    {{-- CONTENT CARD --}}
    <div class="w-full max-w-md">

        <div class="bg-white/80 backdrop-blur-xl border border-white/40
                    shadow-2xl rounded-3xl px-5 sm:px-8 py-6 sm:py-8">

            {{ $slot }}

        </div>

    </div>



    {{-- FOOTER --}}
    <p class="mt-6 text-[11px] sm:text-xs text-gray-500 text-center px-4">
        © {{ date('Y') }} {{ config('app.name', 'Laravel') }}
    </p>

</div>

</body>
</html>