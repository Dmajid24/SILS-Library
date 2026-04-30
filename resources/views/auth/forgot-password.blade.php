<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Forgot Password</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-8
             bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 overflow-hidden">

{{-- BACKGROUND DECOR --}}
<div class="absolute inset-0 -z-10 overflow-hidden">

    <div class="absolute top-0 left-0 w-56 h-56 sm:w-72 sm:h-72 bg-indigo-300 rounded-full blur-3xl opacity-30"></div>

    <div class="absolute bottom-0 right-0 w-56 h-56 sm:w-72 sm:h-72 bg-pink-300 rounded-full blur-3xl opacity-30"></div>

</div>



<div class="w-full max-w-md">

    {{-- CARD --}}
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-6 sm:p-8 border border-white/40">

        {{-- HEADER --}}
        <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-2">
            Forgot Password 🔐
        </h2>

        <p class="text-center text-sm text-gray-500 mb-6 leading-relaxed px-2">
            No problem. Enter your email and we'll send a reset link.
        </p>



        {{-- SUCCESS --}}
        @if (session('status'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('status') }}
        </div>
        @endif



        {{-- ERROR --}}
        @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-600 px-4 py-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
        @endif



        {{-- FORM --}}
        <form method="POST"
              action="{{ route('password.email') }}"
              class="space-y-4">

        @csrf

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   placeholder="Email Address"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200
                          text-sm sm:text-base
                          focus:ring-2 focus:ring-indigo-400 outline-none">

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600
                       text-white py-3 rounded-xl font-semibold shadow-lg
                       hover:scale-[1.02] active:scale-100 transition text-sm sm:text-base">
                Send Reset Link
            </button>

        </form>



        {{-- BACK --}}
        <div class="text-center mt-5">
            <a href="{{ route('login') }}"
               class="text-sm text-gray-500 hover:text-indigo-600 transition">
                ← Back to Login
            </a>
        </div>

    </div>

</div>

</body>
</html>