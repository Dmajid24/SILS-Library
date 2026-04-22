<!DOCTYPE html>
<html>
<head>

<title>{{ $school->name ?? 'SILS Library' }}</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 min-h-screen text-gray-800">

<div class="max-w-7xl mx-auto px-6 py-10">

<!-- ================= NAVBAR ================= -->
<div class="flex justify-between items-center mb-16">

<div class="flex items-center gap-4">

@if(($school ?? null) && $school->logo)
<div class="bg-white/80 p-2 rounded-2xl shadow-md border border-white/70">
<img src="{{ asset('storage/'.$school->logo) }}"
class="w-16 h-16 md:w-20 md:h-20 object-contain">
</div>
@endif

<div>
<h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
{{ $school->name ?? 'SILS Library' }}
</h1>

<p class="text-sm text-gray-500">
Smart Integrated Library
</p>
</div>

</div>

<a href="{{ route('login') }}"
class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-xl font-semibold hover:scale-105 transition shadow-md">

Login

</a>

</div>


<!-- ================= HERO ================= -->
<div class="grid md:grid-cols-2 gap-14 items-center">

{{-- LEFT --}}
<div>

<h2 class="text-5xl font-bold mb-6 leading-tight text-gray-900">

Smart Digital <br>
Library System 🚀

</h2>

<p class="text-lg text-gray-600 mb-10 max-w-lg">

Access your library anytime with a modern, fast, and enjoyable experience. Discover books, borrow easily, and stay connected.

</p>

<div class="flex gap-4">

<a href="{{ route('login') }}"
class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:scale-105 text-white px-7 py-3 rounded-xl font-semibold shadow-lg transition">

Start Exploring

</a>

<a href="#features"
class="px-7 py-3 rounded-xl border border-gray-300 hover:bg-white/70 backdrop-blur transition">

Learn More

</a>

</div>

</div>


{{-- RIGHT CARD --}}
<div class="bg-white/70 backdrop-blur-lg rounded-3xl p-10 shadow-2xl border border-white/50">

<h3 class="text-xl font-semibold mb-6 text-gray-800">
Why Choose This Library?
</h3>

<div class="space-y-5">

<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 text-white flex items-center justify-center rounded-xl shadow">
📚
</div>
<p class="text-gray-600">Borrow books anytime, anywhere</p>
</div>

<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-purple-500 text-white flex items-center justify-center rounded-xl shadow">
🔎
</div>
<p class="text-gray-600">Smart and fast search system</p>
</div>

<div class="flex items-center gap-4">
<div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-pink-500 text-white flex items-center justify-center rounded-xl shadow">
📢
</div>
<p class="text-gray-600">Latest announcements & events</p>
</div>

</div>

</div>

</div>


<!-- ================= FEATURE ================= -->
<div id="features" class="mt-28 grid md:grid-cols-3 gap-8">

<div class="bg-white/80 backdrop-blur p-8 rounded-3xl border shadow-md hover:shadow-xl hover:-translate-y-1 transition">
<h3 class="font-semibold text-lg mb-2">Easy Borrowing</h3>
<p class="text-gray-600 text-sm">
Request books digitally without visiting the library.
</p>
</div>

<div class="bg-white/80 backdrop-blur p-8 rounded-3xl border shadow-md hover:shadow-xl hover:-translate-y-1 transition">
<h3 class="font-semibold text-lg mb-2">Smart Search</h3>
<p class="text-gray-600 text-sm">
Find books instantly by title, author, or category.
</p>
</div>

<div class="bg-white/80 backdrop-blur p-8 rounded-3xl border shadow-md hover:shadow-xl hover:-translate-y-1 transition">
<h3 class="font-semibold text-lg mb-2">Modern Experience</h3>
<p class="text-gray-600 text-sm">
Clean UI designed to be smooth and enjoyable.
</p>
</div>

</div>

</div>


<!-- ================= FOOTER ================= -->
<footer class="mt-24 bg-white/70 backdrop-blur border-t">

<div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10">

{{-- SCHOOL INFO --}}
<div class="flex items-start gap-4">

@if(($school ?? null) && $school->logo)
<div class="bg-white p-2 rounded-2xl shadow border">
<img src="{{ asset('storage/'.$school->logo) }}"
class="w-16 h-16 object-contain">
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

<p class="text-sm text-gray-600 leading-relaxed">
{{ $school->address ?? 'School address not set' }}
</p>
</div>

{{-- CONTACT --}}
<div>
<h4 class="font-semibold text-gray-800 mb-3">
Contact
</h4>

<p class="text-sm text-gray-600">
📧 {{ $school->email ?? '-' }}
</p>

<p class="text-sm text-gray-600 mt-2">
📞 {{ $school->phone ?? '-' }}
</p>
</div>

</div>

<div class="border-t text-center text-sm text-gray-500 py-4">
© {{ date('Y') }} {{ $school->name ?? 'School' }} — Library System
</div>

</footer>

</body>
</html>