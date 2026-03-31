@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto">

<!-- HEADER -->
<div class="relative bg-gradient-to-r from-slate-700 via-indigo-700 to-indigo-600
            rounded-3xl p-8 text-white mb-10 shadow-xl overflow-hidden">

    <div class="absolute -right-20 -top-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -left-10 bottom-0 w-52 h-52 bg-indigo-300/10 rounded-full blur-2xl"></div>

    <h1 class="text-3xl font-semibold tracking-wide">
        🏫 School Details
    </h1>

    <p class="text-indigo-100 mt-2">
        View and manage registered school information.
    </p>

</div>


<!-- SCHOOL CARD -->
<div class="bg-white rounded-3xl shadow-lg p-8">

<div class="grid md:grid-cols-3 gap-10 items-start">

    <!-- LOGO -->
    <div class="flex flex-col items-center">

        <img
            src="{{ $school->logo
                ? asset('storage/'.$school->logo)
                : 'https://placehold.co/200x200' }}"
            class="w-40 h-40 object-cover rounded-2xl shadow mb-4">

        <h2 class="text-xl font-semibold text-gray-800 text-center">
            {{ $school->name }}
        </h2>

    </div>


    <!-- INFORMATION -->
    <div class="md:col-span-2 space-y-6">

        <div>
            <p class="text-sm text-gray-400">Address</p>
            <p class="text-gray-800 font-medium">
                {{ $school->address }}
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-gray-400">Email</p>
                <p class="text-gray-800 font-medium">
                    {{ $school->email ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Phone</p>
                <p class="text-gray-800 font-medium">
                    {{ $school->phone ?? '-' }}
                </p>
            </div>

        </div>

        <div>
            <p class="text-sm text-gray-400">Description</p>
            <p class="text-gray-700 leading-relaxed">
                {{ $school->description ?? 'No description available.' }}
            </p>
        </div>

    </div>

</div>


<!-- ACTION BUTTON -->
<div class="flex justify-end gap-4 mt-10 border-t pt-6">

    <a href="{{ route('superAdmin.dashboard') }}"
       class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
        ← Back
    </a>

    <a href="{{ route('superAdmin.schools.edit',$school->id) }}"
       class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
        Edit
    </a>

    <form action="{{ route('superAdmin.schools.destroy',$school->id) }}"
          method="POST"
          onsubmit="return confirm('Delete this school?')">

        @csrf
        @method('DELETE')

        <button
            class="px-5 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
            Delete
        </button>

    </form>

</div>

</div>

</div>

@endsection