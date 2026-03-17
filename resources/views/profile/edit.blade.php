@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

{{-- PROFILE HEADER --}}
<div class="bg-gradient-to-r from-purple-500 to-indigo-500 rounded-3xl p-8 text-white shadow">

<div class="flex items-center gap-6">

<div class="w-20 h-20 rounded-full bg-white text-purple-600 flex items-center justify-center text-3xl font-bold">
{{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name,0,1)) }}
</div>

<div>

<h1 class="text-2xl font-bold">
{{ auth()->user()->first_name ?? auth()->user()->name }}
</h1>

<p class="opacity-90">
{{ auth()->user()->email }}
</p>

<span class="inline-block mt-2 px-3 py-1 text-sm bg-white/20 rounded-full">
{{ ucfirst(auth()->user()->role) }}
</span>

</div>

</div>

</div>


{{-- PERSONAL INFO --}}
<div class="bg-white shadow rounded-3xl p-8">

<h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center gap-2">
✏️ Personal Information
</h2>

@include('profile.partials.update-profile-information-form')

</div>


{{-- PASSWORD --}}
<div class="bg-white shadow rounded-3xl p-8">

<h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center gap-2">
🔒 Change Password
</h2>

@include('profile.partials.update-password-form')

</div>


{{-- DANGER ZONE --}}
<div class="bg-white shadow rounded-3xl p-8 border border-red-200">

<h2 class="text-xl font-semibold mb-6 text-red-600 flex items-center gap-2">
⚠️ Danger Zone
</h2>

<p class="text-sm text-gray-500 mb-4">
Deleting your account will permanently remove all data.
This action cannot be undone.
</p>

@include('profile.partials.delete-user-form')

</div>

</div>

@endsection