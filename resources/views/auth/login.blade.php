<!DOCTYPE html>
<html>
<head>

<title>Login - {{ $school->name ?? 'Library System' }}</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="min-h-screen flex items-center justify-center px-4 
             bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 overflow-hidden">

{{-- BACKGROUND DECOR --}}
<div class="absolute inset-0 -z-10">

    <div class="absolute top-0 left-0 w-72 h-72 bg-indigo-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-pink-300 rounded-full blur-3xl opacity-30"></div>

</div>


<div class="w-full max-w-md">

    {{-- ================= LOGO ================= --}}
    <div class="text-center mb-8">

        @if($school && $school->logo)
        <div class="bg-white p-3 rounded-2xl shadow inline-block mb-4">
            <img src="{{ asset('storage/'.$school->logo) }}"
                 class="w-16 h-16 object-contain">
        </div>
        @endif

        <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ $school->name ?? 'Library System' }}
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Smart Integrated Library System
        </p>

    </div>


    {{-- ================= CARD ================= --}}
    <div class="bg-white/70 backdrop-blur-xl border border-white/40
                rounded-3xl shadow-2xl p-8 transition">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
            Welcome Back 👋
        </h2>

        <p class="text-gray-500 text-center mb-6 text-sm">
            Please login to continue
        </p>


        {{-- ERROR --}}
        @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
        @endif


        {{-- FORM --}}
        <form method="POST" action="{{ route('login') }}">
        @csrf

        <input
        type="email"
        name="email"
        value="{{ old('email') }}"
        placeholder="Email"
        class="w-full border border-gray-200 rounded-xl px-4 py-3 mb-4
               focus:outline-none focus:ring-2 focus:ring-indigo-400
               bg-white/80 backdrop-blur transition"
        required
        />

        <input
        type="password"
        name="password"
        placeholder="Password"
        class="w-full border border-gray-200 rounded-xl px-4 py-3 mb-6
               focus:outline-none focus:ring-2 focus:ring-purple-400
               bg-white/80 backdrop-blur transition"
        required
        />

        <button
        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600
               hover:scale-[1.02] text-white py-3 rounded-xl font-semibold
               shadow-lg transition">

        Login

        </button>

        </form>

    </div>


    {{-- FOOTER --}}
    <p class="text-center text-gray-500 text-xs mt-6">
        © {{ date('Y') }} {{ $school->name ?? 'School' }}
    </p>

</div>

</body>
</html>