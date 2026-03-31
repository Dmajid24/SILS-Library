@extends('layouts.library')

@section('content')

<div class="max-w-3xl mx-auto">

<!-- HEADER -->
<div class="bg-gradient-to-r from-slate-700 via-indigo-700 to-indigo-600 text-white p-8 rounded-3xl shadow-xl mb-8">

    <h1 class="text-2xl font-semibold">
        ✏️ Edit School
    </h1>

    <p class="text-indigo-100">
        Update school information.
    </p>

</div>


<form action="{{ route('superAdmin.schools.update',$school->id) }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-8 rounded-2xl shadow space-y-6">

@csrf
@method('PUT')


<!-- NAME -->
<div>
    <label class="font-medium text-gray-700">School Name</label>
    <input type="text" name="name"
        value="{{ old('name',$school->name) }}"
        class="w-full mt-2 border rounded-lg px-4 py-2">
</div>

<!-- ADDRESS -->
<div>
    <label class="font-medium text-gray-700">Address</label>
    <textarea name="address"
        class="w-full mt-2 border rounded-lg px-4 py-2">{{ old('address',$school->address) }}</textarea>
</div>

<!-- PHONE -->
<div>
    <label class="font-medium text-gray-700">Phone</label>
    <input type="text" name="phone"
        value="{{ old('phone',$school->phone) }}"
        class="w-full mt-2 border rounded-lg px-4 py-2">
</div>

<!-- EMAIL -->
<div>
    <label class="font-medium text-gray-700">Email</label>
    <input type="email" name="email"
        value="{{ old('email',$school->email) }}"
        class="w-full mt-2 border rounded-lg px-4 py-2">
</div>

<!-- DESCRIPTION -->
<div>
    <label class="font-medium text-gray-700">Description</label>
    <textarea name="description"
        class="w-full mt-2 border rounded-lg px-4 py-2">{{ old('description',$school->description) }}</textarea>
</div>

<!-- LOGO -->
<div>
    <label class="font-medium text-gray-700">Logo</label>

    @if($school->logo)
        <img src="{{ asset('storage/'.$school->logo) }}"
             class="w-20 mb-3 rounded">
    @endif

    <input type="file" name="logo"
        class="w-full mt-2">
</div>


<!-- BUTTON -->
<div class="flex justify-end gap-3">

    <a href="{{ route('superAdmin.dashboard') }}"
       class="px-5 py-2 rounded-lg bg-gray-200">
        Cancel
    </a>

    <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
        Update School
    </button>

</div>

</form>

</div>

@endsection