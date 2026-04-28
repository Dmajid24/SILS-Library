@extends('layouts.library')

@section('content')

<div class="max-w-6xl mx-auto space-y-10">

    {{-- ================= PROFILE HEADER ================= --}}
    <div class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-3xl p-8 text-white shadow-lg overflow-hidden">
        
        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            {{-- LEFT --}}
            <div class="flex items-center gap-5">
                {{-- AVATAR --}}
                <div class="w-20 h-20 rounded-2xl bg-white text-indigo-600 flex items-center justify-center text-3xl font-bold shadow-lg">
                    {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name, 0, 1)) }}
                </div>

                {{-- INFO --}}
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold leading-tight">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </h1>
                    <p class="text-white/80 text-sm mt-1">
                        {{ auth()->user()->email }}
                    </p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 text-xs bg-white/20 rounded-full">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>

                        @if(auth()->user()->phone)
                            <span class="px-3 py-1 text-xs bg-emerald-400/20 rounded-full">
                                📱 {{ auth()->user()->phone }}
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs bg-red-400/20 rounded-full font-medium">
                                ⚠ {{ __('profile.phone_not_added') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT: Member info & Back Button --}}
            <div class="flex flex-col items-end gap-4">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-xs font-semibold transition">
                    ← {{ __('profile.cancel') }}
                </a>
                <div class="text-sm text-white/80 text-right">
                    <p>{{ __('profile.member_since') }}</p>
                    <p class="font-semibold">
                        {{ auth()->user()->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= ALERT PHONE ================= --}}
    @if(empty(auth()->user()->phone))
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="font-semibold text-amber-700">
                    {{ __('profile.complete_phone') }}
                </h3>
                <p class="text-sm text-amber-600 mt-1">
                    {{ __('profile.complete_phone_msg') }}
                </p>
            </div>
            <div class="text-sm text-amber-700 font-medium">
                {{ __('profile.required_borrowing') }} 📚
            </div>
        </div>
    </div>
    @endif

    {{-- ================= GRID CONTENT ================= --}}
    <div class="grid md:grid-cols-2 gap-8">
        {{-- PERSONAL INFO --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                ✏ {{ __('profile.personal_info') }}
            </h2>
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- PASSWORD --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                🔒 {{ __('profile.change_password') }}
            </h2>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- ================= ACCOUNT STATS ================= --}}
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
            <p class="text-sm text-gray-500">{{ __('profile.account_role') }}</p>
            <h3 class="text-xl font-bold text-indigo-600 mt-2">
                {{ ucfirst(auth()->user()->role) }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
            <p class="text-sm text-gray-500">{{ __('profile.email_status') }}</p>
            <h3 class="text-xl font-bold text-emerald-600 mt-2">
                {{ __('profile.verified') }}
            </h3>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
            <p class="text-sm text-gray-500">{{ __('profile.phone_status') }}</p>
            <h3 class="text-xl font-bold mt-2 {{ auth()->user()->phone ? 'text-emerald-600' : 'text-red-500' }}">
                {{ auth()->user()->phone ? __('profile.completed') : __('profile.missing') }}
            </h3>
        </div>
    </div>

    {{-- ================= DANGER ZONE ================= --}}
    <div class="bg-white border border-red-200 shadow-sm rounded-3xl p-8">
        <h2 class="text-lg font-semibold text-red-600 mb-4 flex items-center gap-2">
            ⚠ {{ __('profile.danger_zone') }}
        </h2>
        <p class="text-sm text-gray-500 mb-6">
            {{ __('profile.delete_msg') }}
        </p>
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

@endsection