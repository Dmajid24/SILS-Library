@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-10">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                🏫 {{ __('school.title') }}
            </h1>

            <p class="text-gray-500">
                {{ __('school.subtitle') }}
            </p>
        </div>
    </div>


    {{-- ================= SUCCESS ================= --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow-sm">
        {{ session('success') }}
    </div>
    @endif


    <div class="grid md:grid-cols-3 gap-8">

        {{-- ================= LEFT: PREVIEW ================= --}}
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600
                    text-white rounded-3xl shadow-lg p-6 text-center relative overflow-hidden">

            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

            <div class="relative z-10">
                <p class="text-sm text-white/70 mb-4">{{ __('school.live_preview') }}</p>

                @if($school->logo)
                <img src="{{ asset('storage/'.$school->logo) }}"
                     class="w-24 h-24 object-contain mx-auto mb-4 bg-white rounded-2xl p-2 shadow">
                @else
                <div class="w-24 h-24 mx-auto mb-4 rounded-2xl
                            bg-white/20 flex items-center justify-center text-white">
                    {{ __('school.no_logo') }}
                </div>
                @endif

                <h2 class="font-semibold text-lg">
                    {{ $school->name ?? __('school.school_name') }}
                </h2>

                <p class="text-sm text-white/80 mt-1">
                    {{ $school->email ?? 'school@email.com' }}
                </p>

                <p class="text-xs text-white/60 mt-2">
                    {{ __('school.branding_preview') }}
                </p>
            </div>
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
                    <label class="text-sm text-gray-600 font-medium">
                        {{ __('school.school_name') }}
                    </label>

                    <input type="text" name="name"
                    value="{{ old('name',$school->name) }}"
                    class="w-full mt-2 bg-gray-50 border border-gray-200
                           rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-indigo-400
                           focus:border-indigo-400
                           transition outline-none">
                </div>


                {{-- ADDRESS --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        {{ __('school.address') }}
                    </label>

                    <textarea name="address"
                    rows="3"
                    class="w-full mt-2 bg-gray-50 border border-gray-200
                           rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-indigo-400
                           focus:border-indigo-400
                           transition outline-none">{{ old('address',$school->address) }}</textarea>
                </div>


                {{-- GRID --}}
                <div class="grid md:grid-cols-2 gap-4">

                    {{-- EMAIL --}}
                    <div>
                        <label class="text-sm text-gray-600 font-medium">
                            {{ __('school.email') }}
                        </label>

                        <input type="email" name="email"
                        value="{{ old('email',$school->email) }}"
                        class="w-full mt-2 bg-gray-50 border border-gray-200
                               rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-indigo-400
                               focus:border-indigo-400
                               transition outline-none">
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label class="text-sm text-gray-600 font-medium">
                            {{ __('school.phone') }}
                        </label>

                        <input type="text" name="phone"
                        value="{{ old('phone',$school->phone) }}"
                        class="w-full mt-2 bg-gray-50 border border-gray-200
                               rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-indigo-400
                               focus:border-indigo-400
                               transition outline-none">
                    </div>

                </div>


                {{-- LOGO --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        {{ __('school.school_logo') }}
                    </label>

                    @if($school->logo)
                    <img src="{{ asset('storage/'.$school->logo) }}"
                         class="h-16 mt-3 mb-2 rounded-lg shadow">
                    @endif

                    <input type="file" name="logo"
                    class="w-full mt-2 bg-gray-50 border border-gray-200
                           rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-indigo-400
                           focus:border-indigo-400
                           transition outline-none">
                </div>


                {{-- BUTTON --}}

               
                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ url()->previous() }}" 
                        class="px-6 py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition font-semibold">
                        {{ __('school.cancel') }}
                    </a>
                    <button type="submit"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600
                           hover:opacity-90 text-white px-6 py-3
                           rounded-xl font-semibold shadow-md transition">
                        💾 {{ __('school.save_changes') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection