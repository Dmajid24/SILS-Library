@extends('layouts.library')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                🏫 School Settings
            </h1>
            <p class="text-gray-500">
                Manage your school identity & branding
            </p>
        </div>
    </div>


    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl shadow-sm">
        {{ session('success') }}
    </div>
    @endif


    <div class="grid md:grid-cols-3 gap-6">

        {{-- ================= LEFT: PREVIEW ================= --}}
        <div class="bg-white border rounded-3xl shadow-sm p-6 text-center">

            <p class="text-sm text-gray-400 mb-4">Preview</p>

            @if($school->logo)
            <img src="{{ asset('storage/'.$school->logo) }}"
                 class="w-24 h-24 object-contain mx-auto mb-4">
            @else
            <div class="w-24 h-24 mx-auto mb-4 rounded-full
                        bg-gray-100 flex items-center justify-center text-gray-400">
                No Logo
            </div>
            @endif

            <h2 class="font-semibold text-gray-800 text-lg">
                {{ $school->name ?? 'School Name' }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                {{ $school->email ?? 'school@email.com' }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Branding Preview
            </p>

        </div>


        {{-- ================= RIGHT: FORM ================= --}}
        <div class="md:col-span-2">

            <form action="{{ route('admin.school.update') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="bg-white border rounded-3xl p-8 shadow-sm space-y-6">

                @csrf
                @method('PUT')

                {{-- NAME --}}
                <div>
                    <label class="text-sm text-gray-600">School Name</label>
                    <input type="text" name="name"
                    value="{{ old('name',$school->name) }}"
                    class="w-full mt-2 border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-indigo-400 outline-none">
                </div>

                {{-- ADDRESS --}}
                <div>
                    <label class="text-sm text-gray-600">Address</label>
                    <textarea name="address"
                    class="w-full mt-2 border border-gray-300 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-indigo-400 outline-none"
                    rows="3">{{ old('address',$school->address) }}</textarea>
                </div>

                {{-- GRID --}}
                <div class="grid md:grid-cols-2 gap-4">

                    {{-- EMAIL --}}
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <input type="email" name="email"
                        value="{{ old('email',$school->email) }}"
                        class="w-full mt-2 border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-indigo-400 outline-none">
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label class="text-sm text-gray-600">Phone</label>
                        <input type="text" name="phone"
                        value="{{ old('phone',$school->phone) }}"
                        class="w-full mt-2 border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-indigo-400 outline-none">
                    </div>

                </div>

                {{-- LOGO --}}
                <div>
                    <label class="text-sm text-gray-600">School Logo</label>

                    @if($school->logo)
                    <img src="{{ asset('storage/'.$school->logo) }}"
                         class="h-16 mt-3 mb-2">
                    @endif

                    <input type="file" name="logo"
                    class="w-full mt-2 border border-gray-300 rounded-xl px-4 py-3">
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-4">

                    <button type="submit"
                    class="bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl font-semibold shadow transition">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection