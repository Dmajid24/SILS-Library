@extends('layouts.library')

@section('content')

<div class="max-w-7xl mx-auto space-y-10">

{{-- ================= PHONE ALERT ================= --}}
@if(auth()->check() && auth()->user()->role !== 'admin' && empty(auth()->user()->phone))
<div id="phoneAlert" class="relative overflow-hidden bg-gradient-to-r from-amber-400 via-yellow-400 to-orange-400 rounded-3xl shadow-lg p-[1px] animate-pulse">
    <div class="bg-white rounded-3xl px-6 py-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl">📱</div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ __('dashboard.alert_phone_title') }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ __('dashboard.alert_phone_msg') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
                    {{ __('dashboard.update_now') }}
                </a>
                <button onclick="document.getElementById('phoneAlert').remove()" class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 transition">✕</button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ================= HERO ================= --}}
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-3xl p-10 text-white shadow-lg relative overflow-hidden">
    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">
                {{ __('dashboard.hero_greeting') }} {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}{{ Auth::user()->role == 'lecturer' ? ', ' . Auth::user()->lectureProfile->degree : '' }}
            </h1>
            <p class="text-white/80">{{ __('dashboard.hero_subtitle') }}</p>
        </div>
        <form method="GET" class="w-full md:w-96">
            <input name="search" value="{{ request('search') }}" placeholder="{{ __('dashboard.search_placeholder') }}" class="w-full px-5 py-3 rounded-xl text-gray-700 shadow focus:ring-2 focus:ring-white outline-none" />
        </form>
    </div>
</div>

{{-- ================= ANNOUNCEMENT ================= --}}
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📢 {{ __('dashboard.event_title') }}</h2>
        @if(auth()->user()->role === 'lecturer')
            <a href="{{ route('admin.information.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl shadow hover:bg-indigo-700 transition">
                {{ __('dashboard.manage') }}
            </a>
        @endif
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($info as $i)
        <a href="{{ route('information.show',$i->id) }}">
            <div class="bg-white/80 backdrop-blur border border-white/40 p-6 rounded-2xl shadow-sm hover:shadow-xl transition hover:-translate-y-1">
                <h3 class="font-semibold text-lg text-gray-800 line-clamp-2">{{ $i->title }}</h3>
                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ Str::limit($i->description, 80) }}</p>
                <div class="mt-4 text-indigo-600 text-sm font-medium">{{ __('dashboard.read_more') }} →</div>
            </div>
        </a>
        @empty
            <p class="text-gray-400">{{ __('dashboard.no_announcements') }}</p>
        @endforelse
    </div>
</div>

{{-- ================= BOOK SECTION ================= --}}
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">📚 {{ __('dashboard.explore_title') }}</h2>
        <span class="text-sm text-gray-500">{{ count($book) }} {{ __('dashboard.books_available') }}</span>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($book as $b)
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="relative">
                <img src="{{ $b->cover ? asset('storage/'.$b->cover) : 'https://placehold.co/300x400' }}" class="w-full h-60 object-cover">
                <div class="absolute top-3 right-3 bg-white/90 text-xs px-2 py-1 rounded-lg shadow">
                    {{ $b->stock }} {{ __('dashboard.stock_left') }}
                </div>
            </div>
            <div class="p-5">
                <h3 class="font-semibold text-gray-800 text-lg line-clamp-2">{{ $b->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $b->author }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <span class="text-green-600 text-sm font-medium">{{ __('dashboard.available') }}</span>
                    <a href="{{ route('books.show',$b->id) }}" class="text-indigo-600 text-sm font-semibold hover:underline">{{ __('dashboard.detail') }} →</a>
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-400">{{ __('dashboard.no_books') }}</p>
        @endforelse
    </div>
</div>

{{-- ================= FAQ ================= --}}
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">❓ {{ __('dashboard.faq_title') }}</h2>
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        {{-- ITEM 1 --}}
        <div x-data="{ open: false }" class="bg-white/80 backdrop-blur border border-white/40 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">
            <button @click="open = !open" class="w-full flex justify-between items-center">
                <span class="font-semibold text-gray-800 text-left">{{ __('dashboard.faq_q1') }}</span>
                <span class="text-indigo-600 text-xl" x-text="open ? '−' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">{{ __('dashboard.faq_a1') }}</div>
        </div>
        {{-- ITEM 2 --}}
        <div x-data="{ open: false }" class="bg-white/80 backdrop-blur border border-white/40 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">
            <button @click="open = !open" class="w-full flex justify-between items-center">
                <span class="font-semibold text-gray-800 text-left">{{ __('dashboard.faq_q2') }}</span>
                <span class="text-indigo-600 text-xl" x-text="open ? '−' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">{{ __('dashboard.faq_a2') }}</div>
        </div>
        {{-- ITEM 3 --}}
        <div x-data="{ open: false }" class="bg-white/80 backdrop-blur border border-white/40 rounded-3xl p-6 shadow-sm hover:shadow-xl transition">
            <button @click="open = !open" class="w-full flex justify-between items-center">
                <span class="font-semibold text-gray-800 text-left">{{ __('dashboard.faq_q3') }}</span>
                <span class="text-indigo-600 text-xl" x-text="open ? '−' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-4 text-sm text-gray-500 leading-relaxed">{{ __('dashboard.faq_a3') }}</div>
        </div>
    </div>
</div>

</div>
@endsection