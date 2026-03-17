<!DOCTYPE html>
<html>
<head>

<title>SILS Library</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50 min-h-screen text-gray-800">

<div class="max-w-7xl mx-auto px-6 py-10">

<!-- ================= NAVBAR ================= -->

<div class="flex justify-between items-center mb-20">

<h1 class="text-2xl font-bold text-purple-600 tracking-wide">
📚 SILS
</h1>

<a href="{{ route('login') }}"
class="border border-purple-600 text-purple-600 px-5 py-2 rounded-xl font-semibold hover:bg-purple-50 transition">

Login

</a>

</div>


<!-- ================= HERO ================= -->

<div class="grid md:grid-cols-2 gap-14 items-center">

{{-- LEFT --}}
<div>

<h2 class="text-5xl font-bold mb-6 leading-tight text-gray-900">

Smart <br>
Library System

</h2>

<p class="text-lg text-gray-600 mb-10 max-w-lg">

Discover, explore, and borrow books easily through a modern digital library platform designed for students and lecturers.

</p>

<div class="flex gap-4">

<a href="{{ route('login') }}"
class="bg-purple-600 hover:bg-purple-700 text-white px-7 py-3 rounded-xl font-semibold shadow-sm transition">

Start Exploring

</a>

<a href="#features"
class="px-7 py-3 rounded-xl border border-gray-300 hover:bg-gray-100 transition">

Learn More

</a>

</div>

</div>


{{-- RIGHT CARD --}}
<div class="bg-white rounded-3xl p-10 shadow-sm border">

<h3 class="text-xl font-semibold mb-6 text-gray-800">
Why Use SILS?
</h3>

<div class="space-y-5">

<div class="flex items-center gap-4">
<div class="w-10 h-10 bg-purple-100 text-purple-600 flex items-center justify-center rounded-lg">
📚
</div>
<p class="text-gray-600">Borrow books online anytime</p>
</div>

<div class="flex items-center gap-4">
<div class="w-10 h-10 bg-purple-100 text-purple-600 flex items-center justify-center rounded-lg">
🔎
</div>
<p class="text-gray-600">Search complete library collections</p>
</div>

<div class="flex items-center gap-4">
<div class="w-10 h-10 bg-purple-100 text-purple-600 flex items-center justify-center rounded-lg">
📢
</div>
<p class="text-gray-600">Stay updated with library announcements</p>
</div>

</div>

</div>

</div>


<!-- ================= FEATURE SECTION ================= -->

<div id="features" class="mt-28 grid md:grid-cols-3 gap-8">

<div class="bg-white p-8 rounded-2xl border shadow-sm">
<h3 class="font-semibold text-lg mb-2">Easy Borrowing</h3>
<p class="text-gray-600 text-sm">
Request books digitally without visiting the library counter.
</p>
</div>

<div class="bg-white p-8 rounded-2xl border shadow-sm">
<h3 class="font-semibold text-lg mb-2">Smart Search</h3>
<p class="text-gray-600 text-sm">
Quickly find books by title, author, or category.
</p>
</div>

<div class="bg-white p-8 rounded-2xl border shadow-sm">
<h3 class="font-semibold text-lg mb-2">Modern Experience</h3>
<p class="text-gray-600 text-sm">
Clean and intuitive interface designed for academic environments.
</p>
</div>

</div>




</div>

</body>
<!-- ================= SCHOOL FOOTER ================= -->

{{-- <footer class="mt-24 bg-white border-t">

<div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10 items-start">

    <div class="flex items-start gap-4">

        <img src="{{ asset('images/Logo-smk/al-irsyad.png') }}"
     alt="School Logo"
     class="w-16 h-16 object-contain">
        <div>
            <h3 class="font-bold text-gray-800">
                SMK Al-Irsyad
            </h3>

            <p class="text-sm text-gray-500 mt-2">
                Smart Integrated Library System (SILS)
            </p>
        </div>

    </div>


    <div>
        <h4 class="font-semibold text-gray-800 mb-3">
            Address
        </h4>

        <p class="text-sm text-gray-600 leading-relaxed">
            Jl. KH. Hasyim Ashari No.27, Petojo Utara,
            Gambir, Jakarta Pusat
        </p>
    </div>


    <div>
        <h4 class="font-semibold text-gray-800 mb-3">
            Contact
        </h4>

        <p class="text-sm text-gray-600">
            📧 smk.alirsyad@gmail.com
        </p>

        <p class="text-sm text-gray-600 mt-2">
           📞 (021) 22630265
        </p>
    </div>

</div>

<div class="border-t text-center text-sm text-gray-400 py-4">
    © {{ date('Y') }} SMK BLA BLA BLA — Library System
</div>

</footer> --}}
</html>