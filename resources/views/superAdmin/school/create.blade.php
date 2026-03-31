@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto">

<!-- HEADER -->
<div class="relative bg-gradient-to-r from-slate-700 via-indigo-700 to-indigo-600
            rounded-3xl p-8 text-white mb-10 shadow-xl overflow-hidden">

    <div class="absolute -right-20 -top-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -left-10 bottom-0 w-52 h-52 bg-indigo-300/10 rounded-full blur-2xl"></div>

    <a class="text-3xl font-semibold tracking-wide">
        ➕ Add New School
    </a>

    <p class="text-indigo-100 mt-2">
        Register a new school into the library system.
    </p>

</div>


<!-- FORM CARD -->
<div class="bg-white rounded-3xl shadow-lg p-8">

@if ($errors->any())
<div class="mb-6 bg-red-100 text-red-700 p-4 rounded-lg">
    <ul class="list-disc ml-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<form action="{{ route('superAdmin.schools.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-6">

@csrf

<!-- SCHOOL NAME -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        School Name
    </label>
    <input type="text" name="name" required
        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none">
</div>


<!-- LOGO -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        School Logo
    </label>
    <input type="file" name="logo"
        class="w-full border rounded-xl p-3">
</div>


<!-- ADDRESS -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Address
    </label>
    <textarea name="address" rows="3" required
        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
</div>


<!-- EMAIL & PHONE -->
<div class="grid md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Email
        </label>
        <input type="email" name="email"
            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Phone
        </label>
        <input type="text" name="phone"
            class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>

</div>


<!-- DESCRIPTION -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Description
    </label>
    <textarea name="description" rows="4"
        class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
</div>


<!-- BUTTON -->
<div class="flex justify-end gap-4 pt-6 border-t">

    <a href="{{ route('superAdmin.dashboard') }}"
        class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
        Cancel
    </a>

    <button
        class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
        Save School
    </button>

</div>

</form>

</div>

</div>

@endsection