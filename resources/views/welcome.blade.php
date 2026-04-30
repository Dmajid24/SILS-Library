<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $school->name ?? 'SILS Library' }}</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 min-h-screen text-gray-800 overflow-x-hidden">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">

<!-- ================= NAVBAR ================= -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-5 mb-12 md:mb-16">

    <div class="flex items-center gap-4">

        @if(($school ?? null) && $school->logo)
        <div class="bg-white/80 p-2 rounded-2xl shadow-md border border-white/70 shrink-0">
            <img src="{{ asset('storage/'.$school->logo) }}"
                 class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 object-contain">
        </div>
        @endif

        <div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                {{ $school->name ?? 'SILS Library' }}
            </h1>

            <p class="text-xs sm:text-sm text-gray-500">
                Smart Integrated Library
            </p>
        </div>

    </div>

    <a href="{{ route('login') }}"
       class="w-full sm:w-auto text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:scale-105 transition shadow-md">
        Login
    </a>

</div>



<!-- ================= HERO ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14 items-center">

    {{-- LEFT --}}
    <div>

        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 leading-tight text-gray-900">
            Smart Digital <br class="hidden sm:block">
            Library System 🚀
        </h2>

        <p class="text-base md:text-lg text-gray-600 mb-8 md:mb-10 max-w-lg leading-relaxed">
            Access your library anytime with a modern, fast, and enjoyable experience.
            Discover books, borrow easily, and stay connected.
        </p>

        <div class="flex flex-col sm:flex-row gap-4">

            <a href="{{ route('login') }}"
               class="text-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:scale-105 text-white px-7 py-3 rounded-xl font-semibold shadow-lg transition">
                Start Exploring
            </a>

            <a href="#features"
               class="text-center px-7 py-3 rounded-xl border border-gray-300 hover:bg-white/70 backdrop-blur transition">
                Learn More
            </a>

        </div>

    </div>



    {{-- RIGHT CARD --}}
    <div class="bg-white/70 backdrop-blur-lg rounded-3xl p-6 sm:p-8 md:p-10 shadow-2xl border border-white/50">

        <h3 class="text-lg md:text-xl font-semibold mb-6 text-gray-800">
            Why Choose This Library?
        </h3>

        <div class="space-y-5">

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 text-white flex items-center justify-center rounded-xl shadow shrink-0">
                    📚
                </div>
                <p class="text-gray-600 text-sm md:text-base">
                    Borrow books anytime, anywhere
                </p>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-purple-500 text-white flex items-center justify-center rounded-xl shadow shrink-0">
                    🔎
                </div>
                <p class="text-gray-600 text-sm md:text-base">
                    Smart and fast search system
                </p>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-pink-500 text-white flex items-center justify-center rounded-xl shadow shrink-0">
                    📢
                </div>
                <p class="text-gray-600 text-sm md:text-base">
                    Latest announcements & events
                </p>
            </div>

        </div>

    </div>

</div>



<!-- ================= FEATURE ================= -->
<div id="features" class="mt-20 md:mt-28 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

    <div class="bg-white/80 backdrop-blur p-6 md:p-8 rounded-3xl border shadow-md hover:shadow-xl hover:-translate-y-1 transition">
        <h3 class="font-semibold text-lg mb-2">Easy Borrowing</h3>
        <p class="text-gray-600 text-sm leading-relaxed">
            Request books digitally without visiting the library.
        </p>
    </div>

    <div class="bg-white/80 backdrop-blur p-6 md:p-8 rounded-3xl border shadow-md hover:shadow-xl hover:-translate-y-1 transition">
        <h3 class="font-semibold text-lg mb-2">Smart Search</h3>
        <p class="text-gray-600 text-sm leading-relaxed">
            Find books instantly by title, author, or category.
        </p>
    </div>

    <div class="bg-white/80 backdrop-blur p-6 md:p-8 rounded-3xl border shadow-md hover:shadow-xl hover:-translate-y-1 transition">
        <h3 class="font-semibold text-lg mb-2">Modern Experience</h3>
        <p class="text-gray-600 text-sm leading-relaxed">
            Clean UI designed to be smooth and enjoyable.
        </p>
    </div>

</div>

</div>



<!-- ================= FOOTER ================= -->
<footer class="mt-20 md:mt-24 bg-white/70 backdrop-blur border-t">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">

    {{-- SCHOOL INFO --}}
    <div class="flex items-start gap-4">

        @if(($school ?? null) && $school->logo)
        <div class="bg-white p-2 rounded-2xl shadow border shrink-0">
            <img src="{{ asset('storage/'.$school->logo) }}"
                 class="w-14 h-14 md:w-16 md:h-16 object-contain">
        </div>
        @endif

        <div>
            <h3 class="font-bold text-gray-800">
                {{ $school->name ?? 'School Name' }}
            </h3>

            <p class="text-sm text-gray-500 mt-2">
                Smart Integrated Library System
            </p>
        </div>

    </div>



    {{-- ADDRESS --}}
    <div>
        <h4 class="font-semibold text-gray-800 mb-3">
            Address
        </h4>

        <p class="text-sm text-gray-600 leading-relaxed break-words">
            {{ $school->address ?? 'School address not set' }}
        </p>
    </div>



    {{-- CONTACT --}}
    <div>
        <h4 class="font-semibold text-gray-800 mb-3">
            Contact
        </h4>

        <p class="text-sm text-gray-600 break-all">
            📧 {{ $school->email ?? '-' }}
        </p>

        <p class="text-sm text-gray-600 mt-2">
            📞 {{ $school->phone ?? '-' }}
        </p>
    </div>

</div>

<div class="border-t text-center text-xs sm:text-sm text-gray-500 py-4 px-4">
    © {{ date('Y') }} {{ $school->name ?? 'School' }} — Library System
</div>

</footer>

</body>
</html>