@extends('layouts.library')

@section('content')

<!-- ========================= -->
<!-- WELCOME SUPER ADMIN CARD -->
<!-- ========================= -->

<div class="relative bg-gradient-to-r from-slate-700 via-indigo-700 to-indigo-600 rounded-3xl p-8 text-white mb-10 shadow-xl overflow-hidden">

    <!-- decorative blur -->
    <div class="absolute -right-20 -top-20 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-10 bottom-0 w-52 h-52 bg-indigo-300/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">

        <div>
            <h1 class="text-3xl font-semibold mb-2 tracking-wide">
                👑 Welcome Super Admin
            </h1>

            <p class="text-indigo-100 max-w-lg">
                Manage all schools and control the entire library ecosystem from one dashboard.
            </p>
        </div>

        <!-- ADD SCHOOL BUTTON -->
        <a href="{{ route('superAdmin.schools.create') }}"
           class="relative z-10 bg-white text-indigo-600 font-semibold px-6 py-3 rounded-xl shadow hover:bg-gray-100 transition whitespace-nowrap">
            ➕ Add New School
        </a>

    </div>

</div>



<!-- ========================= -->
<!-- STATISTICS -->
<!-- ========================= -->

<div class="grid md:grid-cols-3 gap-6 mb-12">

    <!-- TOTAL SCHOOL -->
    <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
        <p class="text-gray-500 text-sm">Total Schools</p>
        <h2 class="text-3xl font-bold text-indigo-600 mt-2">
            {{ $totalSchools }}
        </h2>
    </div>

    <!-- TOTAL USERS -->
    <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
        <p class="text-gray-500 text-sm">Total Users</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $totalUsers }}
        </h2>
    </div>

    <!-- TOTAL BOOKS -->
    <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
        <p class="text-gray-500 text-sm">Total Books</p>
        <h2 class="text-3xl font-bold text-purple-600 mt-2">
            {{ $totalBooks }}
        </h2>
    </div>

</div>



<!-- ========================= -->
<!-- SCHOOL HEADER -->
<!-- ========================= -->

<div class="flex justify-between items-center mb-6">

    <h2 class="text-xl font-semibold text-gray-800">
        🏫 Registered Schools
    </h2>

</div>



<!-- ========================= -->
<!-- SCHOOL LIST -->
<!-- ========================= -->

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

@forelse($schools as $school)
<a href="{{ route('superAdmin.schools.show',$school->id) }}">

<div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition hover:-translate-y-1 border border-gray-100">
    <div class="flex items-center gap-4">

        <!-- LOGO -->
        <img
            src="{{ $school->logo ? asset('storage/'.$school->logo) : 'https://placehold.co/80x80' }}"
            class="w-16 h-16 rounded-xl object-cover border"
        >

        <div>
            <h3 class="font-semibold text-gray-800 text-lg">
                {{ $school->name }}
            </h3>

            <p class="text-sm text-gray-500">
                {{ $school->email ?? 'No Email' }}
            </p>
        </div>
            
    </div>

    <p class="text-sm text-gray-400 mt-4">
        {{ $school->address }}
    </p>

    <!-- ACTION -->
    <div class="flex justify-end mt-5">
        
        <p class="text-indigo-600 text-sm font-semibold hover:underline">
            Manage →
        </p>
    </div>

</div>
 </a>
@empty

<div class="col-span-full text-center text-gray-400 py-10">
    No schools registered yet.
</div>

@endforelse

</div>

@endsection