<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login - {{ $school->name ?? 'Library System' }}</title>

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

    {{-- ================= LOGO ================= --}}
    <div class="text-center mb-6 sm:mb-8">

        @if($school && $school->logo)
        <div class="bg-white p-3 rounded-2xl shadow inline-block mb-4">
            <img src="{{ asset('storage/'.$school->logo) }}"
                 class="w-14 h-14 sm:w-16 sm:h-16 object-contain">
        </div>
        @endif

        <h1 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
            {{ $school->name ?? 'Library System' }}
        </h1>

        <p class="text-gray-500 text-xs sm:text-sm mt-1">
            Smart Integrated Library System
        </p>

    </div>



    {{-- ================= CARD ================= --}}
    <div class="bg-white/80 backdrop-blur-xl border border-white/40
                rounded-3xl shadow-2xl p-6 sm:p-8">

        <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-2">
            Welcome Back 👋
        </h2>

        <p class="text-gray-500 text-center mb-6 text-sm">
            Please login to continue
        </p>



        {{-- ERROR --}}
        @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-600 px-4 py-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
        @endif



        {{-- FORM --}}
        <form method="POST"
              action="{{ route('login') }}"
              class="space-y-4">

        @csrf

            {{-- EMAIL --}}
            <div>
                <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Email"
                class="w-full border border-gray-200 rounded-xl px-4 py-3
                       focus:outline-none focus:ring-2 focus:ring-indigo-400
                       bg-white transition text-sm sm:text-base"
                required>
            </div>



            {{-- PASSWORD --}}
            <div>
                <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full border border-gray-200 rounded-xl px-4 py-3
                       focus:outline-none focus:ring-2 focus:ring-purple-400
                       bg-white transition text-sm sm:text-base"
                required>
            </div>



            {{-- FORGOT PASSWORD --}}
            <div class="flex justify-end -mt-1">

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-xs sm:text-sm font-medium text-indigo-600 hover:text-purple-600 transition">
                    Forgot Password?
                </a>
                @endif

            </div>



            {{-- LOGIN BUTTON --}}
            <button
            type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600
                   hover:scale-[1.02] active:scale-100
                   text-white py-3 rounded-xl font-semibold
                   shadow-lg transition text-sm sm:text-base">

                Login

            </button>

        </form>

    </div>



    {{-- FOOTER --}}
    <p class="text-center text-gray-500 text-[11px] sm:text-xs mt-5 sm:mt-6 px-4 leading-relaxed">
        © {{ date('Y') }} {{ $school->name ?? 'School' }}
    </p>

</div>

</body>
</html>